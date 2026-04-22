<?php

namespace App\Http\Controllers;

use App\DTOs\CreateInvoiceDTO;
use App\DTOs\UpdateInvoiceDTO;
use App\Enums\PolicyTypeEnum;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Contract;
use App\Models\Invoice;
use App\Services\InvoiceService;
use App\Traits\HttpResponseTrait;

class InvoiceController extends Controller
{
    use HttpResponseTrait;
    public function __construct(
        private InvoiceService $invoiceService
    ) {
    }

    public function index(Contract $contract)
    {
        $this->authorize(PolicyTypeEnum::VIEW_ANY->value, [Invoice::class, $contract]);

        $invoices = $this->invoiceService->listInvoice($contract->id);

        return $invoices;
    }

    public function show(Invoice $invoice)
    {
        $this->authorize(PolicyTypeEnum::VIEW->value, [Invoice::class, $invoice]);

        $invoice = $this->invoiceService->getDetailedInvoice($invoice->id);

        return $this->success(
            'Invoice Details with Payments',
            InvoiceResource::make($invoice)
        );
    }

    public function store(StoreInvoiceRequest $request, Contract $contract) 
    {
        $this->authorize(PolicyTypeEnum::CREATE->value, [Invoice::class, $contract]);

        $dto = CreateInvoiceDTO::fromRequest($request, $contract);
        
        $invoice = $this->invoiceService->createInvoice($dto);

        return $this->created(
            'Invoice is created successfully',
            InvoiceResource::make($invoice)
        );
    }

    public function update(UpdateInvoiceRequest $request, Invoice $invoice) 
    {
        $this->authorize(PolicyTypeEnum::UPDATE->value, [Invoice::class, $invoice]);

        $dto = UpdateInvoiceDTO::fromRequest($request);
        
        $invoice = $this->invoiceService->updateInvoice($dto, $invoice);

        return $this->success(
            'Invoice is updated successfully',
            InvoiceResource::make($invoice)
        );
    }

    public function destroy(Invoice $invoice) 
    {
        $this->authorize(PolicyTypeEnum::DELETE->value, [Invoice::class, $invoice]);

        $this->invoiceService->deleteInvoice($invoice);

        return $this->noContent(
            'Invoice is deleted successfully'
        );
    }

}
