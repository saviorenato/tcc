<?php

namespace Database\Seeders;

use App\Models\Tax;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Tax::where('id', 1)->first()) {
            Tax::create([
                'id' => 1,
                'mounth' => 10,
                'year' => 2024,
                'amount' => 1000,
                'rule_id' => 1,
                'transactions_id' => json_encode([1, 2]),
                'user_id' => 1,
                'paid' => false,
            ]);
        }
    }
}
