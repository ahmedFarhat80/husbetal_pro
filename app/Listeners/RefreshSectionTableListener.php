<?php

namespace App\Listeners;

use App\Events\RefreshSectionTable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Livewire\Livewire;

class RefreshSectionTableListener
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
    public function handle(RefreshSectionTable $event)
    {
        Livewire::emit('refreshSectionTable');
    }
}
