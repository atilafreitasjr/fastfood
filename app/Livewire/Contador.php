<?php
namespace App\Livewire;

use Livewire\Component;

class Contador extends Component
{
    public $count = 0;

    public function render()
    {
        return view('livewire.contador');
    }

    public function increment($num = 1)
    {
        $this->count += $num;
    }

    public function decrement($num = 1)
    {
        $this->count -= $num;
    }

    public function zerar()
    {
        $this->count = 0;
    }
}
