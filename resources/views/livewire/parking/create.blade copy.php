<div>
    <h1>Novo Registro de Estacionamento</h1>
    <form wire:submit.prevent="save">

        <!-- Select para Fabricantes -->
        {{-- <x-mary-choices-offline
            label="Fabricante"
            wire:change="carregarModelos($event.target.value)"
            :options="$fabricantes"
            placeholder="Selecione um fabricante"
            single
            searchable />

        @if (!empty($modelos))
            <x-mary-choices-offline
                label="Modelo"
                wire:model="car_modelo"
                :options="$modelos"
                placeholder="Selecione um modelo"
                single
                searchable />
        @endif --}}

        <!-- Select para Modelos -->
        {{-- <x-mary-choices-offline
            label="Modelo"
            wire:model="car_modelo"
            :options="$modelos"
            placeholder="Selecione um modelo"
            single
            searchable /> --}}

        <!-- Select para Fabricantes -->
        <select wire:change="carregarModelos($event.target.value)">
            <option value="">Selecione um fabricante</option>
            @foreach ($fabricantes as $fabricante)
                <option value="{{ $fabricante['id'] }}">{{ $fabricante['name'] }}</option>
            @endforeach
        </select>

        <!-- Select para Modelos -->
        @if (!empty($modelos))
            <select wire:model="car_modelo">
                <option value="">Selecione um modelo</option>
                @foreach ($modelos as $modelo)
                    <option value="{{ $modelo['id'] }}">{{ $modelo['name'] }}</option>
                @endforeach
            </select>
        @endif

        <!-- Campo para Placa -->
        <div class="form-group">
            <label for="placa">Placa</label>
            <input type="text" wire:model="placa" id="placa" class="form-control" maxlength="7" required>
            @error('placa') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Campo para Data/Hora de Entrada -->
        <div class="form-group">
            <label for="data_hora_entrada">Entrada</label>
            <input type="datetime-local" id="data_hora_entrada" wire:model="data_hora_entrada" class="form-control" required>
            @error('data_hora_entrada') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Campo para Data/Hora Mary de Entrada -->
        {{-- <div class="form-group">
            <x-mary-datetime label="Entrada" wire:model="data_hora_entrada" name="data_hora_entrada" icon="o-calendar" type="datetime-local" required />
            @error('data_hora_entrada') <span class="text-danger">{{ $message }}</span> @enderror
        </div> --}}

        <!-- Campo para Data/Hora de Saída -->
        {{-- <div class="form-group">
            <x-mary-datetime label="Saída" wire:model="data_hora_saida" name="data_hora_saida" icon="o-calendar" type="datetime-local" />
            @error('data_hora_saida') <span class="text-danger">{{ $message }}</span> @enderror
        </div> --}}

        <!-- Campo para Valor -->
        {{-- <div class="form-group">
            <label for="valor">Valor</label>
            <x-mary-input
                label="Valor"
                wire:model="valor"
                prefix="R$"
                money
                inline
                locale="pt-BR" />
            @error('valor') <span class="text-danger">{{ $message }}</span> @enderror
        </div> --}}

        <div class="form-group">
            <label for="plano">Selecione se tiver plano</label>
            <select wire:model="plano" id="plano" class="form-control">
                <option value="">Nenhum plano</option>
                <option value="1">Mensalista</option>
            </select>
            @error('plano') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
</div>
