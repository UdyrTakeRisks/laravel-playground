<?php

namespace App\Listeners;

use App\Events\InvoiceCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;

class InvoiceCreatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(InvoiceCreatedEvent $event): void
    {
        Log::info('Invoice created with ID: ' . $event->invoice->id);
    }
}
