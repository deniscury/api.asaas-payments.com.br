<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CreditCardRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->validateNumber($value)){
            $fail("O :attribute é inválido!");
        }
    }

    function validateNumber($number) {
        $sum = 0;
        $numDigits = strlen($number);

        for ($i = 0; $i < $numDigits; $i++) {
            $digit = intval($number[$i]);
            // Começando do dígito mais à direita (índice 0)
            if ($i % 2 == 1) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }
            $sum += $digit;
        }

        return ($sum % 10 == 0);
    }
}
