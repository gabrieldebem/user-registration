<?php

namespace App\Http\Livewire;

use App\Services\UserService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class User extends Component
{
    public function render()
    {
        return view('livewire.user');
    }
}
