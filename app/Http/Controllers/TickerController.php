<?php

namespace App\Http\Controllers;

use App\Models\Ticker;
use App\Enum\TickerEnum;
use App\Trait\FormatCPFAndCNPJTrait;
use App\Http\Requests\StoreTickerRequest;
use App\Http\Requests\UpdateTickerRequest;

class TickerController extends Controller
{
    use FormatCPFAndCNPJTrait;

    public function index()
    {
        $acoes = Ticker::where('category', TickerEnum::ACOES->value)
        ->orderBy('ticker', 'ASC')
        ->get();

        foreach ($acoes as $acao) {
            $acao->cnpj = $this->CNPJ($acao->cnpj);
        }

        $fiis = Ticker::where('category', TickerEnum::FIIs->value)
        ->orderBy('ticker', 'ASC')
        ->get();

        foreach ($fiis as $fii) {
            $fii->cnpj = $this->CNPJ($fii->cnpj);
        }

        return view('tickers.index', ['menu' => 'tickers', 'acoes' => $acoes, 'fiis' => $fiis]);
   }

    public function create()
    {
        $tickers = Ticker::pluck('ticker')->all();

        return view('tickers.create', [
            'menu' => 'tickers',
            'tickers' => $tickers,
        ]);
    }

    public function store(StoreTickerRequest $request)
    {
        $request->validated();

        Ticker::create([
            'ticker' => $request->ticker,
            'name' => $request->name,
            'cnpj' => $request->cnpj,
        ]);

        return redirect()->route('tickers.index', [
            'menu' => 'tickers',
            ])->with('success', 'Ticker cadastrado com sucesso!');
    }

    public function show(Ticker $ticker)
    {
        return view('tickers.edit', [
            'menu' => 'tickers',
            'ticker' => $ticker,
        ]);
    }

    public function edit(Ticker $ticker)
    {

        $tickers = Ticker::pluck('ticker')->all();

        return view('tickers.edit', [
            'menu' => 'tickers',
            'selected' => $ticker,
            'tickers' => $tickers,
        ]);
    }

    public function update(UpdateTickerRequest $request, Ticker $ticker)
    {
        $request->validated();

        $ticker->update([
            'ticker' => $request->ticker,
            'name' => $request->name,
            'cnpj' => $request->cnpj,
        ]);

        return redirect()->route('tickers.index', [
            'menu' => 'tickers',
        ])->with('success', 'Ticker atualizado com sucesso!');
    }

    public function destroy(Ticker $ticker)
    {
        $ticker->delete();

        return redirect()->route('tickers.index', [
            'menu' => 'tickers',
        ])->with('success', 'Ticker excluído com sucesso!');
    }
}
