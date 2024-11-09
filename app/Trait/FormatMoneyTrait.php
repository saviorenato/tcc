<?php

namespace App\Trait;

trait FormatMoneyTrait
{
    public function Money($value)
    {
        return 'R$' . number_format($value, 2, ',', '.');
    }
}
