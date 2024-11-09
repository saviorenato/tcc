<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;

    protected $fillable = [
        'mounth',
        'year',
        'amount',
        'rule_id',
        'transactions_id',
        'user_id',
        'paid',
    ];

}
