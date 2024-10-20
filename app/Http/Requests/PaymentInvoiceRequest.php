<?php

namespace App\Http\Requests;

use App\Constants\MessageConstants;
use App\Rules\BillingTypeRule;
use App\Services\AppService;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class PaymentInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array(
            "billing_type" => array("required", new BillingTypeRule),
            "value" => array("required", "numeric", "between:0.01,9999999.99")
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
