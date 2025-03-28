<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController
{
    public function index()
    {
        $cars = Car::all();
        return view('car.index', compact('cars'));
    }

    public function create()
    {
        return view('car.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fabricante' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
        ]);

        Car::create($request->all());
        return redirect()->route('car.index')->with('success', 'Carro criado com sucesso.');
    }

    public function edit($id)
    {
        $car = Car::findOrFail($id);
        return view('car.edit', compact('car'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fabricante' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
        ]);

        $car = Car::findOrFail($id);
        $car->update($request->all());
        return redirect()->route('car.index')->with('success', 'Carro atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        $car->delete();
        return redirect()->route('car.index')->with('success', 'Carro excluído com sucesso.');
    }
}