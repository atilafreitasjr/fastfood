<div>
    <h1 style="font-size: 2rem; margin-bottom: 1.5rem;">Novo Registro de Estacionamento</h1>
    <form wire:submit.prevent="confirmSave" style="font-size: 1.2rem;">

        <!-- Select para Fabricantes -->
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label for="fabricante" style="font-size: 1.2rem;">Carro</label>
            <select wire:model="car_fabricante" wire:change="carregarModelos($event.target.value)" class="form-control" style="height: 3rem; font-size: 1.2rem;">
                <option value="">Selecione um fabricante</option>
                @foreach ($fabricantes as $fabricante)
                    <option value="{{ $fabricante['id'] }}">{{ $fabricante['name'] }}</option>
                @endforeach
            </select>

            <!-- Select para Modelos -->
            @if (!empty($modelos))
            <select wire:model="car_modelo" wire:change="carregarTipos($event.target.value)" class="form-control" style="height: 3rem; font-size: 1.2rem;">
                <option value="">Selecione um modelo</option>
                @foreach ($modelos as $modelo)
                    <option value="{{ $modelo['id'] }}">{{ $modelo['name'] }}</option>
                @endforeach
            </select>
            @endif

            {{-- Select para Tipo de Veículo --}}
            @if ($car_modelo)
            <select wire:model="tipo" id="tipo" class="form-control" style="height: 3rem; font-size: 1.2rem;">
                <option value="">Selecione o tipo</option>
                @foreach ($tipos as $tipo)
                    <option value="{{ $tipo['id'] }}">{{ $tipo['name'] }}</option>
                @endforeach
            </select>
            @error('tipo') <span class="text-danger" style="font-size: 1rem;">{{ $message }}</span> @enderror
            @endif

        </div>

        <!-- Campo para Placa -->
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label for="placa" style="font-size: 1.2rem;">Placa</label>
            <input type="text" wire:model="placa" id="placa" class="form-control" style="height: 3rem; font-size: 1.2rem; text-transform: uppercase;" maxlength="7" required oninput="this.value = this.value.toUpperCase()">
            @error('placa') <span class="text-danger" style="font-size: 1rem;">{{ $message }}</span> @enderror
        </div>

        <!-- Campo para Data/Hora de Entrada -->
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label for="data_hora_entrada" style="font-size: 1.2rem;">Entrada</label>
            <input  type="datetime-local" id="data_hora_entrada" wire:model="data_hora_entrada"
                    class="form-control" style="height: 3rem; font-size: 1.2rem;" required>
            @error('data_hora_entrada') <span class="text-danger" style="font-size: 1rem;">{{ $message }}</span> @enderror
        </div>



        <!-- Campo para Plano -->
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label for="plano" style="font-size: 1.2rem;">Selecione se tiver plano</label>
            <select wire:model="plano" id="plano" class="form-control" style="height: 3rem; font-size: 1.2rem;">
                <option value="">Nenhum plano</option>
                <option value="1">Mensalista</option>
            </select>
            @error('plano') <span class="text-danger" style="font-size: 1rem;">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-success" style="height: 3rem; font-size: 1.2rem; padding: 0 1.5rem;">Imprimir comprovante</button>
    </form>

    <!-- Modal de Confirmação Mary UI -->
    <x-mary-modal wire:model="confirmingSave" class="backdrop-blur" persistent>
        <x-mary-card title="Comprovante de Estacionamento" subtitle="Confira os dados antes de imprimir">
            <div id="comprovante" class="grid grid-cols-2 gap-4 p-4">
                <div>
                    <p class="font-bold">Fabricante:</p>
                    <p>{{ $this->getFabricanteName() }}</p>
                </div>
                <div>
                    <p class="font-bold">Modelo:</p>
                    <p>{{ $this->getModeloName() }}</p>
                </div>
                <div>
                    <p class="font-bold">Placa:</p>
                    <p>{{ $placa }}</p>
                </div>
                <div>
                    <p class="font-bold">Entrada:</p>
                    <p>{{ \Carbon\Carbon::parse($data_hora_entrada)->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="font-bold">Plano:</p>
                    <p>{{ $plano == 1 ? 'Mensalista' : 'Nenhum plano' }}</p>
                </div>
                <div class="col-span-2 mt-4 text-center">
                    <p class="text-sm">Comprovante válido até {{ \Carbon\Carbon::parse($data_hora_entrada)->addHours(24)->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <x-slot:actions>
                <x-mary-button label="Cancelar" @click="$wire.confirmingSave = false" class="btn-ghost" />
                <x-mary-button label="Imprimir e Salvar" wire:click="printAndSave" class="btn-primary" />
            </x-slot:actions>
        </x-mary-card>
    </x-mary-modal>

    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('print-comprovante', () => {
                // Cria um iframe oculto para impressão
                const iframe = document.createElement('iframe');
                iframe.style.position = 'fixed';
                iframe.style.right = '0';
                iframe.style.bottom = '0';
                iframe.style.width = '0';
                iframe.style.height = '0';
                iframe.style.border = '0';

                document.body.appendChild(iframe);

                const comprovante = document.getElementById('comprovante').innerHTML;

                iframe.contentDocument.write(`
                    <!DOCTYPE html>
                    <html>
                        <head>
                            <title>Comprovante de Estacionamento</title>
                            <style>
                                body { font-family: Arial, sans-serif; padding: 20px; }
                                .header { text-align: center; margin-bottom: 20px; }
                                .dados { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
                                .dados p { margin: 5px 0; }
                                .footer { text-align: center; margin-top: 20px; font-size: 12px; }
                                @media print {
                                    body { padding: 0; margin: 0; }
                                    .no-print { display: none !important; }
                                }
                            </style>
                        </head>
                        <body>
                            <div class="header">
                                <h2>Comprovante de Estacionamento</h2>
                                <p>${new Date().toLocaleString()}</p>
                            </div>
                            <div class="dados">
                                ${comprovante}
                            </div>
                            <div class="footer">
                                <p>Este comprovante é válido até ${new Date(new Date().getTime() + 24 * 60 * 60 * 1000).toLocaleString()}</p>
                            </div>
                            <button class="no-print" style="position: fixed; top: 10px; right: 10px;" onclick="window.focus();window.print()">Imprimir</button>
                        </body>
                    </html>
                `);

                iframe.contentDocument.close();

                // Espera o conteúdo carregar
                iframe.onload = function() {
                    setTimeout(() => {
                        iframe.contentWindow.focus();
                        iframe.contentWindow.print();

                        // Redireciona após a impressão
                        setTimeout(() => {
                            window.location.href = "{{ route('parking.index') }}";
                        }, 1000);

                        // Remove o iframe após um tempo
                        setTimeout(() => {
                            document.body.removeChild(iframe);
                        }, 3000);
                    }, 500);
                };
            });
        });
    </script>
    @endpush
</div>
