<?php

namespace App\Http\Livewire;

use App\Models\City;
use App\Models\Event;
use App\Models\Country;
use Livewire\Component;
use Illuminate\Support\Str;

class Events extends Component
{
    public $modalFormVisible = false;
    public $event;
    public $modelId;

    public $selectedCountry;
    public $cities;
    
    public function render()
    {
        return view('livewire.events', [
            'events'    => Event::all(),
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

}
