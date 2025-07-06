<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidCnpj implements Rule
{
    public function passes($attribute, $value)
    {
        $cnpj = preg_replace('/\D/', '', $value);
        if (strlen($cnpj) != 14) return false;
        for ($t = 12; $t < 14; $t++) {
            for ($d = 0, $c = 0, $p = $t - 7; $c < $t; $c++) {
                $d += $cnpj[$c] * $p--;
                if ($p < 2) $p = 9;
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cnpj[$c] != $d) return false;
        }
        return true;
    }

    public function message()
    {
        return 'O CNPJ informado é inválido.';
    }
}
