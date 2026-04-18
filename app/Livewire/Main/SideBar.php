<?php

namespace App\Livewire\Main;

use App\Models\Subforum;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SideBar extends Component
{
    public function render()
    {
        $all = Subforum::all();
        $followed = Auth::user()
        ? Auth::user()->subforums
        : collect();

        return view('livewire.main.side-bar', compact('followed', 'all'));
    }
}
