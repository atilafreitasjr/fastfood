<div>
    <h1>Detalhes do Estacionamento</h1>

    <table class="table-auto border-collapse border border-gray-400 w-full">
        <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2">Placa</th>
                <th class="border border-gray-300 px-4 py-2">Modelo</th>
                <th class="border border-gray-300 px-4 py-2">Entrada</th>
                <th class="border border-gray-300 px-4 py-2">Saída</th>
                <th class="border border-gray-300 px-4 py-2">Valor</th>
                <th class="border border-gray-300 px-4 py-2">Plano</th>
                <th class="border border-gray-300 px-4 py-2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vehicles as $vehicle)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $vehicle->plate }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $vehicle->model }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $vehicle->entry_time }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $vehicle->exit_time }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $vehicle->value }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $vehicle->plan }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <button wire:click="editVehicle({{ $vehicle->id }})" class="bg-blue-500 text-white px-4 py-2 rounded">Editar</button>
                        <button wire:click="removeVehicle({{ $vehicle->id }})" class="bg-red-500 text-white px-4 py-2 rounded">Remover</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
