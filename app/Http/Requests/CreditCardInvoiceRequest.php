<?php

namespace App\Http\Requests;

use App\Constants\MessageConstants;
use App\Rules\CreditCardRule;
use App\Services\AppService;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class CreditCardInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array(
            "card_number" => array("required", new CreditCardRule),
            "expiry_month" => array("required", "date_format:m"),
            "expiry_year" => array("required", "date_format:Y"),
            "ccv" => array("required", "digits_between:3,4"),
        );
    }

    public function messages()
    {
        return MessageConstants::getValidationMessages();
    }
    
    public function withValidator($validator){
        if ($validator->fails()) {
            $response = AppService::return(Response::HTTP_BAD_REQUEST, null, "Algo errado aconteceu", $validator->errors());

            throw new \Illuminate\Validation\ValidationException($validator, $response);
        }
    }
}
