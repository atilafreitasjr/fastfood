<?php
namespace App\Livewire\Parking;

use App\Models\Parking;
use Livewire\Component;

class ParkingIndex extends Component
{
    public $parkings;

    public function mount()
    {
        $this->parkings = Parking::all();
    }

    public function render()
    {
        return view('livewire.parking.index');
    }
}