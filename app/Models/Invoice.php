<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = array('client_id', 'billing_type', 'due_date', 'installment_count', 'installment_value', 'value', 'status', 'payment_id');

    public function client(){
        return $this->hasOne(Client::class);
    }
}