<?php

namespace App\Http\Requests;

use App\Constants\MessageConstants;
use App\Rules\DocumentRule;
use App\Services\AppService;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return array(
            "name" => array("required", "min:3", "max:100"),
            "document" => array("required", "unique:clients", "min:11", "max:14", new DocumentRule),
            "email" => array("required", "unique:clients", "max:200", "email"),
            "phone" => array("required", "unique:clients", "min:3", "max:40"),
            "postal_code" => array("required", "min:8", "max:8"),
            "address" => array("required", "min:3", "max:200"),
            "address_number" => array("required", "max:8")
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
