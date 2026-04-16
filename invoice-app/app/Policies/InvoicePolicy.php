<?php

namespace App\Policies;

use App\Models\Contract;
use App\Models\Invoice;
use App\Models\User;

class InvoicePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can view the models.
     */
    public function viewAny(User $user, Contract $contract): bool
    {
        // passes if the user and the contract belongs to their tenant
        return $user->tenant_id === $contract->tenant_id;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Invoice $invoice): bool
    {
        // passes if the user and the invoice belongs to their tenant
        // $invoice->contract->tenant_id or use the accessor;
        return $user->tenant_id === $invoice->tenant_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Contract $contract): bool
    {
        // passes if the user and the contract belongs to their tenant
        return $user->tenant_id === $contract->tenant_id;
    }
    
     /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Invoice $invoice): bool
    {
        // passes if the user and the invoice belongs to their tenant
        return $user->tenant_id === $invoice->tenant_id;
    }

     /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Invoice $invoice): bool
    {
        // passes if the user and the invoice belongs to their tenant
        return $user->tenant_id === $invoice->tenant_id;
    }
    
}
