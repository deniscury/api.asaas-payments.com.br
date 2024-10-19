<?php

namespace App\Rules;

use App\Constants\AsaasConstants;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BillingTypeRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $billingTypesAllowed = AsaasConstants::BILLING_TYPE;

        if (!in_array($value, $billingTypesAllowed)){
            $fail("O :attribute não é um tipo de cobrança válido!");
        }
    }
}
