<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Users extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.users', [
            'users' => User::paginate(10)
        ]);
    }
}
