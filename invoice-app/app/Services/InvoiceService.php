<?php

namespace App\Services;

use App\Actions\InvoiceNumberGenerator;
use App\DTOs\CreateInvoiceDTO;
use App\DTOs\RecordPaymentDTO;
use App\DTOs\UpdateInvoiceDTO;
use App\Enums\ContractStatusEnum;
use App\Enums\InvoiceStatusEnum;
use App\Events\InvoiceCreatedEvent;
use App\Exceptions\ContractNotActiveException;
use App\Exceptions\ExceededBalanceException;
use App\Exceptions\InsufficientBalanceException;
use App\Interfaces\ContractRepositoryInterface;
use App\Interfaces\InvoiceRepositoryInterface;
use App\Interfaces\PaymentRepositoryInterface;
use App\Jobs\InvoiceCreatedJob;
use App\Traits\FilterTrait;
use Event;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    use FilterTrait;
    public function __construct(
        private ContractRepositoryInterface $contractRepo,
        private InvoiceRepositoryInterface $invoiceRepo,
        private TaxService $taxService,
    ) {
    }

    public function listInvoice(int $contractId): LengthAwarePaginator
    {
        $filters = request()->only('limit', 'status', 'from_date', 'to_date');
        $invoices = $this->invoiceRepo->getByContractId($contractId);

        //apply pagination and filters
        $this->applyFilters($invoices, $filters);
        $limit = $filters['limit'] ?? 10;

        return $invoices->paginate($limit);
    }

    public function getDetailedInvoice(int $invoiceId)
    {
        return $this->invoiceRepo->findById($invoiceId);
    }

    public function createInvoice(CreateInvoiceDTO $dto)
    {
        // multi-step DB operations wrapped in a transaction for atomicity
        return DB::transaction(function () use ($dto) {

            // validate if contract is not active throw ContractNotActiveException
            $contract = $this->contractRepo->findById($dto->contract_id);

            if ($contract->status->value != ContractStatusEnum::ACTIVE->value) {
                throw new ContractNotActiveException();
            }

            // calculate taxes
            $tax = $this->taxService->applyTotalTaxToAmount($dto->subtotal);

            // generate invoice number
            $lastInvoiceNumber = $this->invoiceRepo->getLastInvoiceNumber();
            $invoiceNumber = InvoiceNumberGenerator::generateInvoiceNumber($contract->tenant_id, $lastInvoiceNumber);
            
            // dispatch a job in a queue to send notification to the tenant about the created invoice
            InvoiceCreatedJob::dispatch();

            // store the invoice via repo
            $attributes = array_merge($tax, [
                'contract_id' => $contract->id,
                'invoice_number' => $invoiceNumber,
                'subtotal' => $dto->subtotal,
                'due_date' => $dto->due_date
            ]);

            $invoice = $this->invoiceRepo->create($attributes);

            // dispach event to log the created invoice
            // event(new InvoiceCreatedEvent($invoice));
            // Event::dispatch(new InvoiceCreatedEvent($invoice));
            InvoiceCreatedEvent::dispatch($invoice);

            return $invoice;
        });
    }

    public function updateInvoice(UpdateInvoiceDTO $dto, $invoice)
    {
        return $this->invoiceRepo->update([
            'subtotal' => $dto->subtotal,
            'total' => $dto->total,
            'due_date' => $dto->due_date,
            'status' => $dto->status
        ], $invoice);
    }

    public function deleteInvoice($invoice)
    {
        return $this->invoiceRepo->delete($invoice);
    }

}