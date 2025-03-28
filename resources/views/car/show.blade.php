<html>
<head>
    <title>Detalhes do Carro</title>
</head>
<body>
    <h1>Detalhes do Carro</h1>
    <p><strong>Fabricante:</strong> {{ $car->fabricante }}</p>
    <p><strong>Modelo:</strong> {{ $car->modelo }}</p>
    <p><strong>Criado em:</strong> {{ $car->created_at }}</p>
    <p><strong>Atualizado em:</strong> {{ $car->updated_at }}</p>

    <a href="{{ route('car.index') }}">Voltar para a lista de carros</a>
</body>
</html>