<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livewire Component</title>
    @livewireStyles
</head>
<body>
    <header>
        <h1>Bem-vindo ao Sistema Ovinos</h1>
    </header>

    <main>
        @livewire('contador')
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Sistema Ovinos 2. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
