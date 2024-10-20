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
        $document = preg_replace('/[^0-9]/', '', (string) $document);

        if (strlen($document) != 14){
            return false;
        }
        
	    if (preg_match('/(\d)\1{13}/', $document)){
		    return false;	
        }
        
	    for ($i = 0, $j = 5, $sum = 0; $i < 12; $i++){
		    $sum += $document[$i] * $j;
		    $j = ($j == 2) ? 9 : $j - 1;
	    }

	    $rest = $sum % 11;

	    if ($document[12] != ($rest < 2 ? 0 : 11 - $rest)){
		    return false;
        }

	    for ($i = 0, $j = 6, $sum = 0; $i < 13; $i++){
		    $sum += $document[$i] * $j;
		    $j = ($j == 2) ? 9 : $j - 1;
	    }

	    $rest = $sum % 11;

	    return $document[13] == ($rest < 2 ? 0 : 11 - $rest);
    }

    
}
