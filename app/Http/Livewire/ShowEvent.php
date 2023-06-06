<?php

namespace App\Http\Livewire;

use App\Models\Event;
use Livewire\Component;

class ShowEvent extends Component
{
    public $event;

    public function mount(Int $eventId)
    {
        $this->event = Event::find($eventId);
    }

    public function render()
    {
        return view('livewire.show-event');
    }
}
