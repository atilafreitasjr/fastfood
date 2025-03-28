<?php

namespace App\Livewire\Parking;

use Livewire\Component;

class ParkingShow extends Component
{
    public $parkingSpots = [];
    public $selectedSpot = null;

    public function mount()
    {
        // Inicializa os dados do estacionamento
        $this->parkingSpots = [
            ['id' => 1, 'status' => 'available'],
            ['id' => 2, 'status' => 'occupied'],
            ['id' => 3, 'status' => 'available'],
        ];
    }

    public function selectSpot($spotId)
    {
        // Seleciona uma vaga específica
        $this->selectedSpot = collect($this->parkingSpots)->firstWhere('id', $spotId);
    }

    public function render()
    {
        return view('livewire.parking.parking-show', [
            'parkingSpots' => $this->parkingSpots,
            'selectedSpot' => $this->selectedSpot,
        ]);
    }
}
