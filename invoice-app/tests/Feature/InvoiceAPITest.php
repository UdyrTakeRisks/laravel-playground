<?php

use App\Enums\ContractStatusEnum;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\User;

it('allows an authenticated user to create an invoice', function () {
    $user = User::factory()->create();
    $contract = Contract::factory()->create([
        'tenant_id' => $user->tenant_id
    ]);

    $response = $this->actingAs($user, 'sanctum')->postJson("/api/contracts/{$contract->id}/invoices", [
        'subtotal' => 1000,
        'due_date' => now()->addDays(30)->toDateString(),
    ]);
    if ($contract->status->value != ContractStatusEnum::ACTIVE->value) {
        $response->assertStatus(422);
        return;
    } else {
        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'invoice_number',
                    'subtotal',
                    'tax_amount',
                    'total',
                    'status',
                    'due_date',
                    'paid_at',
                ],
            ]);
    }
});

it('allows an authenticated user to delete an invoice', function () {
    $user = User::factory()->create();
    // authenticate the user first to use it when creating the invoice because the contract tenant's id 
    // needed in the invoice should be the same as the authenticated user's tenant id
    $this->actingAs($user, 'sanctum');
    
    $contract = Contract::factory()->create([
        'tenant_id' => $user->tenant_id
    ]);

    $invoice = Invoice::factory()->create([
        'contract_id' => $contract->id,
    ]);

    $response = $this->deleteJson("/api/invoices/{$invoice->id}");

    $response->assertStatus(204);
});
