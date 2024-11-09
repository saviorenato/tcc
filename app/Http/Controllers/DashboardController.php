<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Trait\FormatDateTrait;
use App\Trait\FormatMoneyTrait;

class DashboardController extends Controller
{
    use FormatMoneyTrait, FormatDateTrait;

    public function index()
    {
        $indicators = $this->indicators();
        $transactions = $this->latestTransactions();
        $taxes = $this->latestTaxes();

        return view('dashboard.index', [
            'menu' => 'dashboard',
            'indicators' => $indicators,
            'transactions' => $transactions,
            'taxes' => $taxes
        ]);
    }

    private function indicators(): array
    {
        return [
            'taxesNotPaid' => Tax::where('user_id', Auth::id())->where('paid', false)->count(),
            'totalTransactions' => Transaction::where('user_id', Auth::id())->count(),
            'totalSale' => $this->Money(Transaction::where('user_id', Auth::id())->sum('amount'))
        ];
    }

    private function latestTransactions(): array
    {
        $transactions = Transaction::orderBy('date', 'DESC')
        ->where('user_id', Auth::id())
        ->with('ticker')
        ->limit(5)
        ->get();

        if (empty($transactions->toArray())) {
            return [];
        }

        foreach ($transactions as $transaction) {
            $transaction->type = $transaction->type == 'C' ? 'Compra' : 'Venda';
            $transaction->date = $this->Date($transaction->date);
            $transaction->amount = $this->Money($transaction->amount);
        }

        return $transactions;
    }

    private function latestTaxes(): array
    {
        (new TaxController)->taxCalculator();

        $taxes = Tax::orderBy('id', 'DESC')
        ->where('user_id', Auth::id())
        ->limit(5)
        ->get();

        if (empty($taxes->toArray())) {
            return [];
        }

        foreach ($taxes as $tax) {
            $tax->amount = $this->Money($tax->amount);
        }

        return $taxes;
    }
}
