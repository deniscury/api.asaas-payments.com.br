<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DocumentRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (strlen($value) == 11){
            if (!$this->validateCPF($value)){
                $fail("O :attribute não é um CPF válido!");
            }
        }
        else if (strlen($value) == 14){
            if (!$this->validateCNPJ($value)){
                $fail("O :attribute não é um CNPJ válido!");
            }
        }
        else{
            $fail("O :attribute é inválido!");
        }
    }

    public function validateCPF($document){
        $document = preg_replace('/[^0-9]/', '', $document);
        
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $i = 0; $i < $t; $i++) {
                $d += $document[$i] * (($t + 1) - $i);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($document[$t] != $d) {
                return false;
            }
        }
        return true;
    }

    public function validateCNPJ($document){
        $document = preg_replace('/[^0-9]/', '', $document);

        for ($i = 5; $i <= 12; $i++) {
            $sum = 0;
            $multiply = 2;
            for ($j = $i; $j >= 0; $j--) {
                $multiply = $multiply <= 9 ? $multiply : 2;
                $sum += $document[$j] * $multiply;
                $multiply++;
            }

            $rest = $sum % 11;
            $digit = $rest < 2 ? 0 : 11 - $rest;
            if ($document[$i - 7] != $digit) {
                return false;
            }
        }
        return true;
    }
}
