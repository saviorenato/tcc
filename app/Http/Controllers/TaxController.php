<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tax;
use App\Models\Rule;
use App\Enum\TaxEnum;
use App\Enum\RuleEnum;
use App\Enum\TickerEnum;
use App\Models\Transaction;
use App\Enum\TransactionEnum;
use App\Trait\FormatMoneyTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateTaxRequest;

class TaxController extends Controller
{
    use FormatMoneyTrait;

    public function index()
    {
        $taxes = Tax::orderBy('id', 'DESC')->get();

        foreach ($taxes as $tax) {
            $tax->amount = $this->Money($tax->amount);
        }

        $this->taxCalculator();

        return view('taxes.index', ['menu' => 'taxes', 'taxes' => $taxes]);
    }

    public function update(UpdateTaxRequest $request, Tax $tax)
    {
        $request->validated();

        $tax->update([
            'paid' => $request->paid,
        ]);

        return redirect()->route('taxes.index', [
            'menu' => 'taxes',
        ])->with('success', 'Imposto atualizado com sucesso!');
    }

    public function taxCalculator(): void
    {
        $calculateTaxAcoes = $this->calculateTaxAcoes();
        $calculateTaxFIIs = $this->calculateTaxFIIs();

        $this->registerTax($calculateTaxAcoes, $calculateTaxFIIs);
    }

    private function calculateTaxAcoes(): array
    {
        $transactionsMonth = $this->transactionsMonthAcoes();
        $acoesDayTrade = $this->calculateAcoesDayTrade($transactionsMonth);
        $acoesSwingTrade = $this->calculateAcoesSwingTrade($transactionsMonth, $acoesDayTrade);

        return [
            'Acoes' => [
                'dayTrade' => $acoesDayTrade,
                'swingTrade' => $acoesSwingTrade
            ]
        ];
    }

    private function transactionsMonthAcoes(): array
    {
        $transactions = Transaction::whereMonth('date', '<', Carbon::now()->month)
        ->whereYear('date', '=', Carbon::now()->year)
        ->where('user_id', Auth::id())
        ->whereHas('ticker', function ($query) {
            $query->where('category', TickerEnum::ACOES);
        })
        ->with('ticker')
        ->get();

        return $transactions->groupBy('ticker.ticker')->toArray();
    }

    private function transactionAlreadyCalculated($transactionsId): bool
    {
        $isProcessad = Tax::whereJsonContains('transactions_id', $transactionsId)
        ->where('mounth', '<', Carbon::now()->month)
        ->where('year', '=', Carbon::now()->year)
        ->orWhere('year', '=', Carbon::now()->year - 1)
        ->where('user_id', Auth::id())
        ->first();

        if ($isProcessad) {
            return true;
        }

        return false;
    }

    private function calculateAcoesDayTrade($transactionsMonth): array
    {
        $dayTrade = [];
        foreach ($transactionsMonth as $ticker => $transactions) {

            $inDayTrade = false;

            foreach ($transactions as $transaction) {

                if ($transaction['type'] == TransactionEnum::VENDA->value) {

                    if ($this->transactionAlreadyCalculated([$transaction['id']])) {
                        continue;
                    }

                    foreach ($transactions as $validateDaytrade) {
                        if ($validateDaytrade['type'] == TransactionEnum::COMPRA->value) {
                            if ($validateDaytrade['date'] == $transaction['date']) {

                                foreach ($dayTrade as $value) {
                                    if (isset($value['transactions_id']) && $value['transactions_id'] == $transaction['id']) {
                                        $inDayTrade = true;
                                    }
                                }

                                if (!$inDayTrade) {
                                    $ruleDayTrade = Rule::where('id', RuleEnum::DAYTRADE)->first();
                                    $dayTrade[] = [
                                        'transactions_id' => $transaction['id'],
                                        'date' => $transaction['date'],
                                        'amount' => ($transaction['amount'] * $transaction['quantity']) * ($ruleDayTrade->aliquot / 100)
                                    ];
                                }

                            }
                        }
                    }
                }
            }
        }

        return $dayTrade;
    }

    private function calculateAcoesSwingTrade($transactionsMonth, $acoesDayTrade): array
    {
        $swingTrade = [];
        $swingTradeCalculate = [
            'transactions_id' => [],
            'date' => "",
            'amount' => 0
        ];
        foreach ($transactionsMonth as $ticker => $transactions) {

            $inDayTrade = false;

            foreach ($transactions as $transaction) {

                if ($transaction['type'] == TransactionEnum::VENDA->value) {

                    if ($this->transactionAlreadyCalculated([$transaction['id']])) {
                        continue;
                    }

                    foreach ($acoesDayTrade as $value) {
                        if ($value['transactions_id'] == $transaction['id']) {
                            $inDayTrade = true;
                        }
                    }

                    if ($inDayTrade) { continue; }

                    $swingTrade[] = [
                        'transaction' => $transaction['id'],
                        'date' => $transaction['date'],
                        'amount' => $transaction['amount'] * $transaction['quantity']
                    ];
                }
            }
        }

        foreach ($swingTrade as $swingTradeTransaction) {
            $swingTradeCalculate['transactions_id'][] = $swingTradeTransaction['transaction'];
            $swingTradeCalculate['date'] = $swingTradeTransaction['date'];
            $swingTradeCalculate['amount'] += $swingTradeTransaction['amount'];
        }

        $ruleSwingTrade = Rule::where('id', RuleEnum::SWINGTRADE)->first();

        if ((float) $swingTradeCalculate['amount'] > (float) $ruleSwingTrade->amount) {
            $swingTradeCalculate['amount'] = $swingTradeCalculate['amount'] * ($ruleSwingTrade->aliquot / 100);
            return $swingTradeCalculate;
        }

        $swingTradeCalculate['amount'] = 0;
        return $swingTradeCalculate;
    }

    private function calculateTaxFIIs(): array
    {
        $transactionsMonth = $this->transactionsMonthFIIs();

        return [
            'FIIs' => $this->calculateFIIs($transactionsMonth)
        ];
    }

    private function transactionsMonthFIIs(): array
    {
        $transactions = Transaction::whereMonth('date', '=', Carbon::now()->month - 1)
        ->whereYear('date', '=', Carbon::now()->year)
        ->where('user_id', Auth::id())
        ->whereHas('ticker', function ($query) {
            $query->where('category', TickerEnum::FIIs);
        })
        ->with('ticker')
        ->get();

        return $transactions->groupBy('ticker.ticker')->toArray();
    }

    private function calculateFIIs($transactionsMonth): array
    {
        $fiiTrade = [];
        $fiiTradeCalculate = [
            'transactions_id' => [],
            'date' => "",
            'amount' => 0
        ];
        foreach ($transactionsMonth as $ticker => $transactions) {

            foreach ($transactions as $transaction) {

                if ($transaction['type'] == TransactionEnum::VENDA->value) {

                    if ($this->transactionAlreadyCalculated([$transaction['id']])) {
                        continue;
                    }

                    $fiiTrade[] = [
                        'transaction' => $transaction['id'],
                        'date' => $transaction['date'],
                        'amount' => $transaction['amount'] * $transaction['quantity']
                    ];
                }
            }
        }

        foreach ($fiiTrade as $fiiTradeTransaction) {
            $fiiTradeCalculate['transactions_id'][] = $fiiTradeTransaction['transaction'];
            $fiiTradeCalculate['amount'] += $fiiTradeTransaction['amount'];
        }

        $ruleFiiTrade = Rule::where('id', RuleEnum::FUNDOIMOBILIARIO)->first();

        if ((float) $fiiTradeCalculate['amount'] > (float) $ruleFiiTrade->amount) {
            $fiiTradeCalculate['date'] = $fiiTradeTransaction['date'];
            $fiiTradeCalculate['amount'] = $fiiTradeCalculate['amount'] * ($ruleFiiTrade->aliquot / 100);
            return $fiiTradeCalculate;
        }

        $fiiTradeCalculate['amount'] = 0;
        return $fiiTradeCalculate;
    }

    private function registerTax($acoes, $fiis): void
    {
        foreach($acoes as $taxAcoes) {
            if ($taxAcoes[TaxEnum::DAYTRADE->value]) {
                foreach($taxAcoes[TaxEnum::DAYTRADE->value] as $dayTrade) {
                    if (isset($dayTrade['amount']) && $dayTrade['amount'] == 0) { continue; }
                    Tax::create([
                        'mounth' => Carbon::parse($dayTrade['date'])->month,
                        'year' => Carbon::parse($dayTrade['date'])->year,
                        'amount' => $dayTrade['amount'],
                        'rule_id' => RuleEnum::DAYTRADE->value,
                        'transactions_id' => json_encode([$dayTrade['transactions_id']]),
                        'user_id' => Auth::id(),
                        'paid' => false
                    ]);
                }
            }

            if ($taxAcoes[TaxEnum::SWINGTRADE->value]) {
                $swingTrade = $taxAcoes[TaxEnum::SWINGTRADE->value];
                if (isset($swingTrade['amount']) && $swingTrade['amount'] == 0) { continue; }
                Tax::create([
                    'mounth' => Carbon::parse($swingTrade['date'])->month,
                    'year' => Carbon::parse($swingTrade['date'])->year,
                    'amount' => $swingTrade['amount'],
                    'rule_id' => RuleEnum::SWINGTRADE->value,
                    'transactions_id' => json_encode($swingTrade['transactions_id']),
                    'user_id' => Auth::id(),
                    'paid' => false
                ]);
            }
        }

        foreach($fiis as $fiisTrade) {
            if (isset($fiisTrade['amount']) && $fiisTrade['amount'] == 0) { continue; }
            Tax::create([
                'mounth' => Carbon::parse($fiisTrade['date'])->month,
                'year' => Carbon::parse($fiisTrade['date'])->year,
                'amount' => $fiisTrade['amount'],
                'rule_id' => RuleEnum::FUNDOIMOBILIARIO->value,
                'transactions_id' => json_encode($fiisTrade['transactions_id']),
                'user_id' => Auth::id(),
                'paid' => false
            ]);
        }
    }

}
