<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = array('name', 'document', 'email', 'phone', 'postal_code', 'address', 'address_number', 'customer_id');

    public function invoices(){
        return $this->hasMany(Invoice::class);
    }
}
