<?php

namespace App\Constants;

class MessageConstants
{
    const VALIDATION_MESSAGES = array(
        'required' => 'O campo :attribute é obrigatório.',
        'min' => 'O campo :attribute deve conter no mínimo :min caracteres.',
        'max' => 'O campo :attribute deve conter no máximo :max caracteres.',
        'integer' => 'O campo :attribute deve ser um número inteiro.',
        'decimal' => 'O campo :attribute deve ser um número decimal.',
        'numeric' => 'O campo :attribute deve ser um número.',
        'between' => 'O campo :attribute deve conter um número entre :min e :max.',
        'exists' => 'Identificamos que o registro já existe.',
        'unique' => 'Identificamos que o :attribute :input já existe.',
        'date_format' => 'O campo :attribute está no formato incorreto.',
        'email' => 'O email preenchido é inválido.'
    );

    public static function getValidationMessages(){
        return self::VALIDATION_MESSAGES;
    }
}