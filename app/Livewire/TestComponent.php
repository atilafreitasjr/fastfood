<?php
namespace App\Http\Livewire;

use Livewire\Component;

class TestComponent extends Component
{
    public $testValue = '';

    public function render()
    {
        return view('livewire.test-component');
    }
}