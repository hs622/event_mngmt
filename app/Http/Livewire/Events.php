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
    public $countries;
    public $cities;
    
    public function mount() {
        $this->countries = Country::where('status', 1)->get();
        $this->cities = collect();
    }

    public function render()
    {
        return view('livewire.events');
    }

    public function createShowModal() {
        $this->resetValidation();
        $this->reset();
        $this->modalFormVisible = true;
    }

    public function updatedCountry(int $countryId) {
        $this->cities = City::where('status', 1)->where('country_id', $countryId)->get();
    }

}
