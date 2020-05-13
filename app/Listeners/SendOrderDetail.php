<?php

namespace App\Listeners;

use App\Events\OrderRegistered;
use App\Jobs\SendEmail;
use App\Mail\OrderEmailRegistered;
use App\Models\Shop\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderDetail
{
    /**
     * @var Order
     */

    /**
     * Create the event listener.
     *
     * @param Order $order
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param OrderRegistered $event
     * @return void
     */
    public function handle(OrderRegistered $event)
    {
        SendEmail::dispatch($event->order->user, new OrderEmailRegistered($event->order));
    }
}
