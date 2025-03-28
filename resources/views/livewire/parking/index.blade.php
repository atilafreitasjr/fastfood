<div>
    <h1>Lista de Estacionamentos</h1>
    <a href="{{ route('parking.create') }}" class="btn btn-primary">Novo Registro</a>

    <!-- Tabela 1: Registros sem data_hora_saida -->
    <h2>Estacionamentos Ativos</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Carro</th>
                <th>Placa</th>
                <th>Entrada</th>
                <th>Valor</th>
                <th>Plano</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($parkings->where('data_hora_saida', null) as $parking)
                <tr>
                    <td>{{ $parking->id }}</td>
                    <td>{{ $parking->car_id }}</td>
                    <td>{{ $parking->placa }}</td>
                    <td>{{ $parking->data_hora_entrada }}</td>
                    <td>{{ $parking->valor }}</td>
                    <td>{{ $parking->plano }}</td>
                    <td>
                        <a href="{{ route('parking.edit', $parking->id) }}" class="btn btn-warning">Saída</a>
                        {{-- <a href="{{ route('parking.show', $parking->id) }}" class="btn btn-info">Detalhes</a> --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr class="my-4"> <!-- Linha divisória com margem vertical -->

    <!-- Tabela 2: Registros com data_hora_saida -->
    <h2>Estacionamentos Finalizados</h2>
    <form method="GET" action="{{ route('parking.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="enable_date_filter" name="enable_date_filter" value="1" {{ request('enable_date_filter') ? 'checked' : '' }}>
                    <label class="form-check-label" for="enable_date_filter">Filtrar por Período</label>
                </div>
            </div>
            <div id="date_filter_inputs" class="row g-3" style="display: none;">
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Data Inicial</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date', now()->startOfMonth()->toDateString()) }}" disabled>
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">Data Final</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date', now()->toDateString()) }}" disabled>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </div>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Carro</th>
                <th>Placa</th>
                <th>Entrada</th>
                <th>Saída</th>
                <th>Valor</th>
                <th>Plano</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @php
                $filteredParkings = $parkings->where('data_hora_saida', '!=', null)
                    ->filter(function ($parking) {
                        $startDate = request('start_date');
                        $endDate = request('end_date');

                        dump($startDate, $endDate);

                        if (request('enable_date_filter') && $startDate && $endDate) {
                            // Verifica se a data_hora_saida está entre start_date e end_date
                            return $parking->data_hora_saida >= $startDate && $parking->data_hora_saida <= $endDate;
                        } else {
                            // Filtro padrão: apenas registros com data_hora_saida igual à data atual
                            $today = now()->toDateString();
                            return \Carbon\Carbon::parse($parking->data_hora_saida)->toDateString() === $today;
                        }
                    });
            @endphp
            @foreach ($filteredParkings as $parking)
                <tr>
                    <td>{{ $parking->id }}</td>
                    <td>{{ $parking->car_id }}</td>
                    <td>{{ $parking->placa }}</td>
                    <td>{{ $parking->data_hora_entrada }}</td>
                    <td>{{ $parking->data_hora_saida }}</td>
                    <td>{{ $parking->valor }}</td>
                    <td>{{ $parking->plano }}</td>
                    <td>
                        <a href="{{ route('parking.show', $parking->id) }}" class="btn btn-info">Detalhes</a>
                    </td>
                </tr>
            @endforeach
            <tfoot>
                <tr>
                    <td colspan="5" class="text-end"><strong>Total:</strong></td>
                    <td colspan="2">{{ $filteredParkings->sum('valor') }}</td>
                </tr>
            </tfoot>
        </tbody>
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const enableDateFilterCheckbox = document.getElementById('enable_date_filter');
            const dateFilterInputs = document.getElementById('date_filter_inputs');
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');

            // Define a visibilidade inicial com base no estado do checkbox
            const toggleDateInputs = () => {
                if (enableDateFilterCheckbox.checked) {
                    dateFilterInputs.style.display = 'flex';
                    startDateInput.disabled = false;
                    endDateInput.disabled = false;
                } else {
                    dateFilterInputs.style.display = 'none';
                    startDateInput.disabled = true;
                    endDateInput.disabled = true;
                }
            };

            // Inicializa o estado dos inputs
            toggleDateInputs();

            // Alterna a visibilidade dos inputs de período com base no estado do checkbox
            enableDateFilterCheckbox.addEventListener('change', toggleDateInputs);
        });
    </script>
</div>