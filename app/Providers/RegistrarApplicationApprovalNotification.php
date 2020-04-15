<?php

namespace App\Providers;

use App\Providers\StudentApplicationProcessed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RegistrarApplicationApprovalNotification
{
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
     * @param  StudentApplicationProcessed  $event
     * @return void
     */
    public function handle(StudentApplicationProcessed $event)
    {
        //
    }
}
