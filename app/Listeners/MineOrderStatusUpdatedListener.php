<?php

namespace App\Listeners;

use App\Events\MineOrderStatusUpdatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\MineOrder;
use Log;
use App\Jobs\Mine;

class MineOrderStatusUpdatedListener
{
    protected $mineOrder;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MineOrderStatusUpdatedEvent  $event
     * @return void
     */
    public function handle(MineOrderStatusUpdatedEvent $event)
    {
        Mine::dispatch($event->mineOrder->id)
              ->onConnection('redis');
    }

   
}
