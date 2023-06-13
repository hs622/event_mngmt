<?php

namespace App\Http\Livewire;

use App\Models\Country;
use Livewire\Component;
use App\Models\Category;

class Setting extends Component
{
    public $categories;
    public $countries;
    public $cities;

    public function mount() {
        $this->categories = Category::all();
        $this->countries = Country::all();
    }

    public function render() {
        return view('livewire.setting');
    }
}
