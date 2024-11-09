<?php

namespace App\Trait;

use Carbon\Carbon;

trait FormatDateTrait
{
    public function Date($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }
}
