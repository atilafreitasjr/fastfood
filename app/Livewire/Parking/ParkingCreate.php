<?php
namespace App\Livewire\Parking;

use App\Models\Parking;
use Livewire\Component;
use App\Models\Car;

class ParkingCreate extends Component
{
    public $car_id, $placa, $data_hora_entrada, $data_hora_saida, $valor, $plano;
    public $fabricantes = []; // Lista de fabricantes
    public $modelos = []; // Lista de modelos filtrados
    public $car_fabricante; // ID do fabricante selecionado
    public $car_modelo; // ID do modelo selecionado

    public function mount()
    {
        $this->fabricantes = Car::distinct('fabricante')
            ->get(['fabricante'])
            ->map(function ($item) {
                return [
                    'id' => $item->fabricante, // ID do fabricante
                    'name' => $item->fabricante, // Nome do fabricante
                ];
            })
            ->toArray();
    }

    public function carregarModelos($fabricante)
    {
        // Verificar se o fabricante foi selecionado
        if (!$fabricante) {
            $this->modelos = []; // Limpar os modelos se nenhum fabricante for selecionado
            return;
        }

        // Carregar os modelos com base no fabricante selecionado
        $this->modelos = Car::where('fabricante', $fabricante)
            ->get(['id', 'modelo'])
            ->map(function ($item) {
                return [
                    'id' => $item->id, // ID do modelo
                    'name' => $item->modelo, // Nome do modelo
                ];
            })
            ->toArray();

        $this->car_modelo = null; // Resetar o modelo selecionado
    }

    // public function updatedCarFabricante($fabricante)
    // {
    //     $this->modelos = Car::where('fabricante', $fabricante)
    //         ->get(['id', 'modelo'])
    //         ->map(function ($item) {
    //             return [
    //                 'id' => $item->id, // ID do modelo
    //                 'name' => $item->modelo, // Nome do modelo
    //             ];
    //         })
    //         ->toArray();

    //     $this->car_modelo = null; // Resetar o modelo selecionado
    // }

    public function save()
    {
        $this->car_id = $this->car_modelo;

        $this->validate([
            'car_id' => 'required|exists:car,id',
            'placa' => 'required|max:7',
            'data_hora_entrada' => 'required|date',
            'data_hora_saida' => 'nullable|date',
            'valor' => 'nullable|numeric',
            'plano' => 'nullable|integer',
        ]);

        // dd([
        //     'car_id' => $this->car_id,
        //     'placa' => $this->placa,
        //     'data_hora_entrada' => $this->data_hora_entrada,
        //     'data_hora_saida' => $this->data_hora_saida,
        //     'valor' => $this->valor,
        //     'plano' => $this->plano,
        // ]);

        Parking::create([
            'car_id' => $this->car_id,
            'placa' => $this->placa,
            'data_hora_entrada' => $this->data_hora_entrada,
            'data_hora_saida' => $this->data_hora_saida,
            'valor' => $this->valor,
            'plano' => $this->plano,
        ]);

        session()->flash('success', 'Registro criado com sucesso!');
        return redirect()->route('parking.index');
    }

    public function render()
    {
        return view('livewire.parking.create');
    }
}
