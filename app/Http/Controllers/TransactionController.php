<?php

namespace App\Http\Controllers;

use App\Models\Ticker;
use App\Models\Transaction;
use App\Trait\FormatMoneyTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Trait\FormatDateTrait;

class TransactionController extends Controller
{
    use FormatMoneyTrait, FormatDateTrait;

    public function index()
    {
         $transactions = Transaction::orderBy('date', 'DESC')
             ->where('user_id', Auth::id())
             ->with('ticker')
             ->paginate(perPage: 10);

         foreach ($transactions as $transaction) {
            $transaction->type = $transaction->type == 'C' ? 'Compra' : 'Venda';
            $transaction->date = $this->Date($transaction->date);
            $transaction->amount = $this->Money($transaction->amount);
         }

         return view('transaction.index', ['menu' => 'transactions', 'transactions' => $transactions]);
    }

    public function create()
    {
        $tickers = Ticker::pluck('ticker')->all();

        return view('transaction.create', [
            'menu' => 'transactions',
            'tickers' => $tickers,
            'user_id' => Auth::id()
        ]);
    }

    public function store(StoreTransactionRequest $request)
    {

        $request->validated();

        $ticker = Ticker::where('ticker', $request->ticker)->first();

        Transaction::create([
            'type' => $request->type,
            'ticker_id' => $ticker,
            'user_id' => Auth::id(),
            'date' => $request->date,
            'amount' => $request->amount,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('transactions.index', [
            'menu' => 'transaction',
            ])->with('success', 'Transação cadastrada com sucesso!');
    }

    public function show(Transaction $transaction)
    {
        if ($transaction->user_id != Auth::id()) {
            return redirect()->route('transactions.index', [
                'menu' => 'transaction',
            ])->with('error', 'Transação inválida!');
        }

        $tickers = Ticker::pluck('ticker')->all();

        return view('transaction.edit', [
            'menu' => 'transaction',
            'type' => 'Editar',
            'tickers' => $tickers,
            'transaction' => $transaction,
        ]);
    }

    public function edit(Transaction $transaction)
    {
        if ($transaction->user_id != Auth::id()) {
            return redirect()->route('transactions.index', [
                'menu' => 'transaction',
            ])->with('error', 'Transação inválida!');
        }

        $tickers = Ticker::pluck('ticker')->all();

        return view('transaction.edit', [
            'menu' => 'transaction',
            'type' => 'Editar',
            'tickers' => $tickers,
            'transaction' => $transaction,
        ]);
    }

    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        if ($transaction->user_id != Auth::id()) {
            return redirect()->route('transactions.index', [
                'menu' => 'transaction',
            ])->with('error', 'Transação inválida!');
        }

        $request->validated();

        $ticker = Ticker::where('ticker', $request->ticker)->first();

        $transaction->update([
            'type' => $request->type,
            'ticker_id' => $ticker,
            'user_id' => Auth::id(),
            'date' => $request->date,
            'amount' => $request->amount,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('transactions.index', [
            'menu' => 'transaction',
        ])->with('success', 'Transação atualizada com sucesso!');
    }

    public function destroy(Transaction $transaction)
    {
        if ($transaction->user_id != Auth::id()) {
            return redirect()->route('transactions.index', [
                'menu' => 'transaction',
            ])->with('error', 'Transação inválida!');
        }

        $transaction->delete();

        return redirect()->route('transactions.index', [
            'menu' => 'transaction',
        ])->with('success', 'Transação excluída com sucesso!');
    }
}
