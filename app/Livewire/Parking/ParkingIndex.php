<?php

namespace App\Livewire\Parking;

use App\Models\Parking;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class ParkingIndex extends Component
{
    use WithPagination;

    public $enableDateFilter = false;
    public $startDate;
    public $endDate;
    public $perPage = 20;

    protected $queryString = [
        'enableDateFilter' => ['except' => false],
        'startDate' => ['except' => ''],
        'endDate' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    public function mount()
    {
        $this->startDate = $this->startDate ?? now()->startOfMonth()->toDateString();
        $this->endDate = $this->endDate ?? now()->toDateString();
    }

    public function render()
    {
        $activeParkings = Parking::with('car')
            ->whereNull('data_hora_saida')
            ->orderBy('data_hora_entrada', 'desc')
            ->get();

        $completedParkingsQuery = Parking::with('car')
            ->whereNotNull('data_hora_saida')
            ->orderBy('data_hora_saida', 'desc');

        if ($this->enableDateFilter) {
            // Filtro por período quando ativado
            $completedParkingsQuery->whereBetween('data_hora_saida', [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay()
            ]);
        } else {
            // Filtro por data atual quando desativado
            $completedParkingsQuery->whereDate('data_hora_saida', Carbon::today());
        }

        $completedParkings = $completedParkingsQuery->paginate($this->perPage);
        $totalValue = $completedParkings->sum('valor');

        return view('livewire.parking.index', [
            'activeParkings' => $activeParkings,
            'completedParkings' => $completedParkings,
            'totalValue' => $totalValue,
        ]);
    }
}