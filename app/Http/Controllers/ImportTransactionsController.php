<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ticker;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Http\Requests\ImportTransactionsRequest;

class ImportTransactionsController extends Controller
{
    public function ImportExcel(ImportTransactionsRequest $request)
    {
        $filePath = $request->file('file')->getRealPath();
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        $firstRow = true;
        foreach ($sheet->getRowIterator() as $row) {
            if ($firstRow) {
                $firstRow = false;
                continue;
            }

            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $rowDataWithTitles = [];
            $titles = ['A' => 'data', 'B' => 'categoria', 'C' => 'ticker', 'D' => 'tipo', 'E' => 'quantidade', 'F' => 'valor'];
            foreach ($cellIterator as $key => $cell) {
                $rowDataWithTitles[$titles[$key]] = $cell->getValue();

                if (empty($rowDataWithTitles[$titles[$key]])) {
                    continue 2;
                }
            }

            $ticker = Ticker::where('ticker', $rowDataWithTitles['ticker'])->first();

            Transaction::create([
                'date' => Carbon::createFromFormat('Y-m-d H:i:s', Date::excelToDateTimeObject($rowDataWithTitles['data'])->format('Y-m-d H:i:s'))->format('Y-m-d'),
                'user_id' => Auth::id(),
                'ticker_id' => $ticker->id,
                'type' => $rowDataWithTitles['tipo'],
                'quantity' => (int) preg_replace('/[.,].*$/', '', $rowDataWithTitles['quantidade']),
                'amount' => (float) str_replace(',', '.', $rowDataWithTitles['valor']),
            ]);
        }

        return redirect()->route('transactions.index', [
            'menu' => 'transaction',
            ])->with('success', 'Transação Importadas com sucesso!');
    }


    public function downloadExcel()
    {
        $filePath = public_path('files/modelo_transacoes_import.xlsx');
        return response()->download($filePath, "modelo_importacao_transacoes.xlsx");
    }
}


