@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Carro</h1>
    <form action="{{ route('car.update', $car->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="fabricante">Fabricante</label>
            <input type="text" class="form-control" id="fabricante" name="fabricante" value="{{ $car->fabricante }}" required>
        </div>

        <div class="form-group">
            <label for="modelo">Modelo</label>
            <input type="text" class="form-control" id="modelo" name="modelo" value="{{ $car->modelo }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Atualizar</button>
        <a href="{{ route('car.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection