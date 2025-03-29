<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Car;
use Illuminate\Http\Request;

class EntradaVeiculo extends Component
{
    public $fabricante;
    public $modelo;
    public $cars;

    public function mount()
    {
        $this->cars = Car::all();
    }

    public function render()
    {
        return view('livewire.entrada-veiculo', ['cars' => $this->cars]);
    }

    public function store()
    {
        $this->validate([
            'fabricante' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
        ]);

        Car::create([
            'fabricante' => $this->fabricante,
            'modelo' => $this->modelo,
        ]);

        session()->flash('success', 'Carro criado com sucesso.');
        $this->reset(['fabricante', 'modelo']);
        $this->cars = Car::all(); // Atualiza a lista de carros
    }

    public function edit($id)
    {
        $car = Car::findOrFail($id);
        $this->fabricante = $car->fabricante;
        $this->modelo = $car->modelo;
    }

    public function update($id)
    {
        $this->validate([
            'fabricante' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
        ]);

        $car = Car::findOrFail($id);
        $car->update([
            'fabricante' => $this->fabricante,
            'modelo' => $this->modelo,
        ]);

        session()->flash('success', 'Carro atualizado com sucesso.');
        $this->reset(['fabricante', 'modelo']);
        $this->cars = Car::all(); // Atualiza a lista de carros
    }

    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        $car->delete();

        session()->flash('success', 'Carro excluído com sucesso.');
        $this->cars = Car::all(); // Atualiza a lista de carros
    }
}
