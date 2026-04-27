<?php

namespace App\Livewire\Main;

use Livewire\Component;

class SearchBar extends Component
{
    public string $query = '';

    public function search()
    {
        if (trim($this->query) === '') {
            return;
        }

        return redirect()->route('search', ['q' => $this->query]);
    }

    public function render()
    {
        return view('livewire.main.search-bar');
    }
}
