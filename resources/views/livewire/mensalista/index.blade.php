<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Mensalistas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <input type="text" wire:model.live="search" placeholder="Buscar mensalista..." class="w-full p-2 border rounded">
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CPF</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($mensalistas as $mensalista)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $mensalista->nome }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $mensalista->cpf }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $mensalista->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('mensalista.edit', $mensalista->id) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                        <button wire:click="delete({{ $mensalista->id }})" class="ml-2 text-red-600 hover:text-red-900">Excluir</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $mensalistas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
