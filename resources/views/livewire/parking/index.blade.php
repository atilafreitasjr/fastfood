@push('scripts')
    @livewireScripts
@endpush

<div>
    <div class="container">
        <h1 class="mb-4">Lista de Estacionamentos</h1>

        <div class="mb-4">
            <a href="{{ route('parking.create') }}" class="btn btn-primary">
                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Estacionar Carro
            </a>
        </div>

        <!-- Tabela de Estacionamentos Ativos -->
        <div class="card mb-5">
            <div class="card-header bg-primary text-white">
                <h2 class="h5 mb-0">Estacionamentos Ativos</h2>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Carro</th>
                                <th>Placa</th>
                                <th>Entrada</th>
                                <th>Plano</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($activeParkings as $parking)
                                <tr>
                                    <td>{{ $parking->id }}</td>
                                    <td>{{ $parking->car->modelo ?? 'N/A' }}</td>
                                    <td>{{ $parking->placa }}</td>
                                    <td>{{ $parking->data_hora_entrada->format('d/m/Y H:i') }}</td>
                                    <td>{{ $parking->plano }}</td>
                                    <td>
                                        <a href="{{ route('parking.edit', $parking->id) }}"
                                           class="btn btn-sm btn-warning"
                                           title="Registrar Saída">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Nenhum estacionamento ativo no momento</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tabela de Estacionamentos Finalizados -->
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h2 class="h5 mb-0">Estacionamentos Finalizados</h2>
                <small class="text-white-50">
                    @if($enableDateFilter)
                    Mostrando registros de {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} até {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
                    @else
                    Mostrando registros de hoje ({{ \Carbon\Carbon::today()->format('d/m/Y') }})
                    @endif
                </small>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox"
                               id="enable_date_filter" wire:model.live="enableDateFilter">
                        <label class="form-check-label" for="enable_date_filter">
                            Filtrar por Período Customizado
                        </label>
                    </div>

                    @if($enableDateFilter)
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="start_date" class="form-label">Data Inicial</label>
                            <input type="date" id="start_date" wire:model.live="startDate"
                                   class="form-control" max="{{ now()->toDateString() }}">
                        </div>
                        <div class="col-md-4">
                            <label for="end_date" class="form-label">Data Final</label>
                            <input type="date" id="end_date" wire:model.live="endDate"
                                   class="form-control" max="{{ now()->toDateString() }}">
                        </div>
                    </div>
                    @endif
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Carro</th>
                                <th>Placa</th>
                                <th>Entrada</th>
                                <th>Saída</th>
                                <th>Valor</th>
                                <th>Plano</th>
                                {{-- <th>Ações</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($completedParkings as $parking)
                                <tr>
                                    <td>{{ $parking->id }}</td>
                                    <td>{{ $parking->car->modelo ?? 'N/A' }}</td>
                                    <td>{{ $parking->placa }}</td>
                                    <td>{{ $parking->data_hora_entrada->format('d/m/Y H:i') }}</td>
                                    <td>{{ $parking->data_hora_saida->format('d/m/Y H:i') }}</td>
                                    <td>R$ {{ number_format($parking->valor, 2, ',', '.') }}</td>
                                    <td>{{ $parking->plano }}</td>
                                    {{-- <td>
                                        <a href="{{ route('parking.show', $parking->id) }}"
                                           class="btn btn-sm btn-info"
                                           title="Detalhes">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    </td> --}}
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Nenhum estacionamento finalizado encontrado</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="table-active">
                                <td colspan="5" class="text-end fw-bold">Total:</td>
                                <td colspan="3">R$ {{ number_format($totalValue, 2, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $completedParkings->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
