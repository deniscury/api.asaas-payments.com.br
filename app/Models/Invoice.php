<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = array('client_id', 'billing_type', 'due_date', 'value', 'status', 'payment_id');

    public function client(){
        return $this->belongsTo(Client::class);
    }
}
