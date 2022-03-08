<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Header extends Component
{
    public function render()
    {
        return view('livewire.header');
    }

    public function signup()
    {
        return redirect()->route('signup');
    }
}
