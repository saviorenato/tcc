<?php

namespace Database\Seeders;

use App\Models\Rule;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Rule::where('id', 1)->first()) {
            Rule::create([
                'id' => 1,
                'name' => 'Isento',
                'aliquot' => 0,
                'amount' => 0
            ]);
        }

        if (!Rule::where('id', 2)->first()) {
            Rule::create([
                'id' => 2,
                'name' => 'Swing Trade',
                'aliquot' => 15,
                'amount' => 20000
            ]);
        }

        if (!Rule::where('id', 3)->first()) {
            Rule::create([
                'id' => 3,
                'name' => 'Day Trade',
                'aliquot' => 20,
                'amount' => 0
            ]);
        }

        if (!Rule::where('id', 4)->first()) {
            Rule::create([
                'id' => 4,
                'name' => 'Fundo Imobiliario',
                'aliquot' => 20,
                'amount' => 20000
            ]);
        }
    }
}

