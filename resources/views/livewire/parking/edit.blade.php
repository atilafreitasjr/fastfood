<div class="card shadow-lg p-4">
    <h1 class="text-xl font-bold mb-4">Editar Registro de Estacionamento</h1>
    <form wire:submit.prevent="save">

        <!-- Informações do Carro -->
        <div class="form-group mb-4">
            <h2 class="text-lg font-semibold">Informações do Carro</h2>
            <p><strong>Fabricante:</strong> {{ $car_fabricante }}</p>
            <p><strong>Modelo:</strong> {{ $car_modelo ? $modelos[array_search($car_modelo, array_column($modelos, 'id'))]['name'] ?? '' : '' }}</p>
            <!-- Inputs Hidden para Fabricante e Modelo -->
            <input type="hidden" wire:model="car_fabricante" name="car_fabricante">
            <input type="hidden" wire:model="car_modelo" name="car_modelo">
        </div>

        <!-- Campo para Placa -->
        <div class="form-group mb-4">
            <h2 class="text-lg font-semibold">Informações da Placa</h2>
            <p><strong>Placa:</strong> {{ $placa }}</p>
            <input type="hidden" wire:model="placa" name="placa">
        </div>

        <!-- Campo para Data/Hora de Entrada -->
        <div class="form-group mb-4">
            <h2 class="text-lg font-semibold">Horário de Entrada</h2>
            <p><strong>Data/Hora de Entrada:</strong> {{ $data_hora_entrada }}</p>
            <input type="hidden" wire:model="data_hora_entrada" name="data_hora_entrada">
        </div>

        <!-- Campo para Data/Hora de Saída -->
        <div class="form-group mb-4">
            <h2 class="text-lg font-semibold">Horário de Saída</h2>
            <p><strong>Data/Hora de Saída:</strong> {{ $data_hora_saida }}</p>
            <input type="hidden" wire:model="data_hora_saida" name="data_hora_saida">
        </div>

        <!-- Campo para Tempo de Permanência -->
        <div class="form-group mb-4">
            <h2 class="text-lg font-semibold">Tempo de Permanência</h2>
            <p class="text-2xl font-bold"><strong>Tempo:</strong> {{ $tempo_permanencia }}</p>
        </div>

        <!-- Campo para Valor -->
        <div class="form-group mb-4">
            <h2 class="text-lg font-semibold">Valor Calculado</h2>
            <p class="text-2xl font-bold"><strong>Valor:</strong> R$ {{ number_format($valor, 2, ',', '.') }}</p>
            <input type="hidden" wire:model="valor" name="valor">
        </div>

        <!-- Campo para Plano -->
        <div class="form-group mb-4">
            <h2 class="text-lg font-semibold">Plano</h2>
            <p><strong>Plano:</strong> {{ $plano == 1 ? 'Mensalista' : 'Avulso' }}</p>
            <input type="hidden" wire:model="plano" name="plano">
        </div>

        <!-- Botões -->
        <div class="flex justify-end space-x-4">
            <button type="submit" class="btn btn-success">Realizar Cobrança</button>
            <a href="{{ route('parking.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>