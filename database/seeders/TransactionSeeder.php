<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactions = [
            ['id' => 1, 'type' => 'C', 'ticker_id' => 930, 'user_id' => 1, 'date' => '2024-04-10', 'amount' => 11.24, 'quantity' => 6000],
            ['id' => 2, 'type' => 'C', 'ticker_id' => 50, 'user_id' => 1, 'date' => '2024-10-05', 'amount' => 32.80, 'quantity' => 2000],
            ['id' => 3, 'type' => 'V', 'ticker_id' => 50, 'user_id' => 1, 'date' => '2024-10-05', 'amount' => 32.90, 'quantity' => 600],
            ['id' => 4, 'type' => 'C', 'ticker_id' => 50, 'user_id' => 1, 'date' => '2024-10-05', 'amount' => 32.81, 'quantity' => 20],
            ['id' => 5, 'type' => 'C', 'ticker_id' => 519, 'user_id' => 1, 'date' => '2024-10-10', 'amount' => 89.20, 'quantity' => 1180],
            ['id' => 6, 'type' => 'C', 'ticker_id' => 307, 'user_id' => 1, 'date' => '2024-10-11', 'amount' => 66.81, 'quantity' => 10],
            ['id' => 7, 'type' => 'V', 'ticker_id' => 930, 'user_id' => 1, 'date' => '2024-10-18', 'amount' => 12.05, 'quantity' => 3000],
            ['id' => 8, 'type' => 'V', 'ticker_id' => 930, 'user_id' => 1, 'date' => '2024-10-20', 'amount' => 11.04, 'quantity' => 38],
        ];

        foreach ($transactions as $transaction) {
            $existingTransaction = Transaction::where('id', $transaction['id'])->first();
            if (!$existingTransaction) {
                Transaction::create([
                    'id' => $transaction['id'],
                    'type' => $transaction['type'],
                    'ticker_id' => $transaction['ticker_id'],
                    'user_id' => $transaction['user_id'],
                    'date' => $transaction['date'],
                    'amount' => $transaction['amount'],
                    'quantity' => $transaction['quantity'],
                ]);
            }
        }
    }
}
