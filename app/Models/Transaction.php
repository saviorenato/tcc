<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'ticker_id',
        'user_id',
        'date',
        'amount',
        'quantity',
    ];

    public function ticker(): BelongsTo
    {
        return $this->belongsTo(Ticker::class, 'ticker_id');
    }

}
