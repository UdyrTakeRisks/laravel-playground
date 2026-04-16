<?php

namespace App\DTOs;


use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Contract;

class UpdateInvoiceDTO
{
    public function __construct(
        public readonly float $subtotal,
        public readonly float $total,
        public readonly string $due_date,
        public readonly string $status,
    ) {
    }

    public static function fromRequest(UpdateInvoiceRequest $request): self
    {
        return new self(
            subtotal: $request->validated('subtotal'),
            total: $request->validated('total'),
            due_date: $request->validated('due_date'),
            status: $request->validated('status'),
        );
    }
}