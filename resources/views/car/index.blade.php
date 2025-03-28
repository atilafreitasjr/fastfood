<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Carros</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Lista de Carros</h1>
        <a href="{{ route('car.create') }}" class="btn btn-primary">Adicionar Novo Carro</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fabricante</th>
                    <th>Modelo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cars as $car)
                    <tr>
                        <td>{{ $car->id }}</td>
                        <td>{{ $car->fabricante }}</td>
                        <td>{{ $car->modelo }}</td>
                        <td>
                            <a href="{{ route('car.edit', $car->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('car.destroy', $car->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Excluir</button>
                            </form>
                            <a href="{{ route('car.show', $car->id) }}" class="btn btn-info">Ver</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>