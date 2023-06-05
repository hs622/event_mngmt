<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Roles extends Component
{
    public $title = '';
    public $description = '';
    public $content = '';

    public function render()
    {
        return view('livewire.roles');
    }
}
