<?php

namespace App\Livewire;

use Livewire\Component;

class SearchBar extends Component
{
    public function render()
    {
        return view('livewire.search-bar')->layout('components.layouts.front-end-layout');
    }
}
