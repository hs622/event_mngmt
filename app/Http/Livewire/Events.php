<?php

namespace App\Http\Livewire;

use App\Models\City;
use App\Models\Event;
use App\Models\Country;
use App\Models\Enroll;
use App\Models\Schedule;
use Livewire\Component;
use Illuminate\Support\Str;

class Events extends Component
{
    public $modalFormVisible = false;
    public $enrolledModal = false;
    public $deleteModal = false;

    public $deleteSelectedEvent;
    public $event;
    public $modelId;

    public $selectedCountry;
    public $cities;
    
    public function render()
    {
        return view('livewire.events', [
            'events'    => Event::whereNotIn('id', auth()->user()->events->pluck('event_id'))->get(),
            'countries' => Country::where('status', 1)->get(),
            'cities' => $this->cities,
        ]);
    }

    protected $rules = [
        'event' => 'required|array',
        'event.title' => 'required|min:5',
        'event.venue' => 'required|min:10',
        'event.description' => 'required|min:15',
        'selectedCountry' => 'required|integer',
        'event.city' => 'required|integer',
    ];

    protected $messages = [
        'event.title' => 'Please insert title which must have 5 charater',
    ];

    public function createShowModal() {
        $this->resetValidation();
        $this->reset();
        $this->modalFormVisible = true;
    }

    public function updatedSelectedCountry(int $countryId) {
        $this->cities = City::where('status', 1)
            ->where('country_id', $countryId)
            ->get()
            ->pluck('name', 'id');
    }

    public function store() {
        $this->validate();

        $event = Event::create([
            'title'         => $this->event['title'],
            'slug'          => Str::slug($this->event['title']) ,
            'description'   => $this->event['description'],
            'status'        => $this->event['status'] ? 1 : 0
        ]);

        $event->schedule()->create([
            'event_id' => $event->id,
            'venue' => $this->event['venue'],
            'country_id' => $this->selectedCountry,
            'city_id' => $this->event['city'],
            'start_ed' => now(),
            'end_ed' => now(),
        ]);

        $this->reset();
        $this->modalFormVisible = false;
        session()->flash('message', 'Event created successfully.');
    }

    public function deleteShowModal($eventId) {
        $this->deleteSelectedEvent = Event::find($eventId);
        $this->deleteModal = true;
    }

    public function deleteConfirmed() {
        Schedule::where('event_id', $this->deleteSelectedEvent->id)->delete();
        Event::find($this->deleteSelectedEvent->id)->delete();
        $this->deleteModal = false;
    }

    public function enrolledInEvent(int $eventId) {
        
        // dd($eventId, auth()->user()->events);
        // if(in_array($eventId, auth()->user()->events->pluck('event_id'))) {
        // } else {
            Enroll::create([
                'user_id'   => auth()->user()->id,
                'event_id'  => $eventId,
            ]);
            
            $this->enrolledModal = true;
        // }
    }
}
