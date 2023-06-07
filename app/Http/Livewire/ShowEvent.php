<?php

namespace App\Http\Livewire;

use App\Models\Event;
use Livewire\Component;

class ShowEvent extends Component
{
    public $event;

    public function mount(String $eventSlug)
    {
        $this->event = Event::where('slug', $eventSlug)->first();
    }

    public function render()
    {
        return view('livewire.show-event');
    }
}
