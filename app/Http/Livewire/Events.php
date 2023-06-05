<?php

namespace App\Http\Livewire;

use App\Models\City;
use App\Models\Country;
use Livewire\Component;

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
            'countries' => Country::where('status', 1)->get(),
            'cities' => $this->cities,
        ]);
    }

    protected $rules = [
        'event' => 'required|array',
        'event.title' => 'required|min:5',
        'event.venue' => 'required|min:10',
        'event.description' => 'required|mix:15',
        'event.country' => 'required|integer',
        'event.city' => 'required|integer',
    ];

    protected $messages = [
        'event.title' => 'Please insert title which must have 5 charater',
        'event.venue' => 'required|min:10',
        'event.description' => 'required|mix:15',
        'event.country' => 'required|integer',
        'event.city' => 'required|integer',
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
        $validatedData = $this->validate();

        dd($validatedData);
    }

}
