<?php

namespace App\Services;

use App\Constants\MessageConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class AppService
{
    protected static $validationMessages = MessageConstants::VALIDATION_MESSAGES;

    public static function validate(Request $request, array $rules){
        $error = array();
        $validate = Validator::make($request->all(), $rules, self::$validationMessages);

        if($validate->fails()){
            $error = $validate->errors();
        }

        return $error;
    }
    
    public static function return(int $status = 200, $data = null, string $message = "Sucesso", MessageBag $error = null){
        if (!is_null($message)){
            $retorno['message'] = $message;
        }

        if(!is_null($data) && !empty($data)){
            $retorno['data'] = $data;
        }

        if(!is_null($error)){
            $retorno['error'] = $error;
        }

        return response()->json($retorno, $status);
    }    
}