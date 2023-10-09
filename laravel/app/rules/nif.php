<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Str;

class Nif implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return ($this->isValidCif(strtoupper($value)) || $this->isValidNif(strtoupper($value)) || $this->isValidNie(strtoupper($value)));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El campo NIF no tiene un formato Válido.';
    }


    public function isValidCif($data)
    {
        $cif = str_replace("-", "", $data);

        $cif_codes = 'JABCDEFGHI';

        $sum = (string) $this->getCifSum($cif);

        $n = (10 - substr($sum, -1)) % 10;

        $cifRegEx = '/^[a-zA-Z][0-9]{8}$/i';

        if (preg_match($cifRegEx, $cif)) {
            if (in_array($cif[0], array('A', 'B', 'E', 'H'))) {
                // Numerico
                return ($cif[8] == $n);
            } elseif (in_array($cif[0], array('K', 'P', 'Q', 'S'))) {
                // Letras
                return ($cif[8] == $cif_codes[$n]);
            } else {
                // Alfanumérico
                if (is_numeric($cif[8])) {
                    return ($cif[8] == $n);
                } else {
                    return ($cif[8] == $cif_codes[$n]);
                }
            }
        }

        return false;
    }

    function getCifSum($cif)
    {
        if (Str::length($cif) < 8 || !is_int($cif[2]) || !is_int($cif[4]) || !is_int($cif[6]))
            return 0;

        $sum = $cif[2] + $cif[4] + $cif[6];

        for ($i = 1; $i < 8; $i += 2) {
            $tmp = (string) (2 * $cif[$i]);

            $tmp = $tmp[0] + ((strlen($tmp) == 2) ? $tmp[1] : 0);

            $sum += $tmp;
        }

        return $sum;
    }

    public function isValidNif($data)
    {
        $nif = str_replace("-", "", $data);
        $nifRegEx = '/^[0-9]{8}[a-zA-Z]$/i';
        $letras = "TRWAGMYFPDXBNJZSQVHLCKE";

        if (preg_match($nifRegEx, $nif)) {
            return ($letras[(substr($nif, 0, 8) % 23)] == $nif[8]);
        }

        return false;
    }

    public function isValidNie($nif)
    {



        $nieRegEx = '/^[KLMXYZ][0-9]{7}[a-zA-Z]$/i';
        $letras = "TRWAGMYFPDXBNJZSQVHLCKE";

        if (preg_match($nieRegEx, $nif)) {
            $r = str_replace(['X', 'Y', 'Z'], [0, 1, 2], $nif);

            return ($letras[(substr($r, 0, 8) % 23)] == $nif[8]);
        }

        return false;
    }
}