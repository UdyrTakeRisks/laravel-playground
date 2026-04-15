<?php

namespace App\Models;

use App\Enums\InvoiceStatusEnum;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['contract_id', 'subtotal', 'due_date', 'tax_amount', 'total', 'invoice_number', 'status', 'paid_at'])]
class Invoice extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => InvoiceStatusEnum::class
    ];

    /**
     * relationships
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    /**
     * Accessors 
     */
    // (Note: call it as tenant_id)
    public function getTenantIdAttribute()
    {
        return $this->contract?->tenant_id;
    }
}
