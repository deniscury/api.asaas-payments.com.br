<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'document' => $this->document,
            'email' => $this->email,
            'phone' => $this->phone,
            'postal_code' => $this->postal_code,
            'address' => $this->address,
            'address_number' => $this->address_number,
            'deleted_at' => $this->deleted_at,
            'invoices' => $this->whenLoaded('invoices'),
            'customer_id' => $this->customer_id,
            'asaas_data' => $this->whenHas('asaas')
        );
    }
}
