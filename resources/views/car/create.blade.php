<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Carro</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Criar Novo Carro</h1>
        <form action="{{ route('car.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="fabricante">Fabricante</label>
                <input type="text" name="fabricante" id="fabricante" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="modelo">Modelo</label>
                <input type="text" name="modelo" id="modelo" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Criar Carro</button>
        </form>
        <a href="{{ route('car.index') }}" class="btn btn-secondary">Voltar</a>
    </div>
</body>
</html>