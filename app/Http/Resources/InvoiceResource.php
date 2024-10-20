<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            'billing_type' => $this->billing_type,
            'due_date' => $this->due_date,
            'value' => $this->value,
            'status' => $this->status,
            'client_id' => $this->client_id,
            'client' => $this->whenLoaded('client'),
            'payment_id' => $this->payment_id,
            'asaas_data' => $this->whenHas('asaas'),
            'pix' => $this->whenHas('pix'),
            'bill' => $this->whenHas('bill'),
            'credit_card' => $this->whenHas('credit_card')
        );
    }
}
