<?php
namespace App\Livewire\Parking;

use App\Models\Parking;
use Livewire\Component;
use App\Models\Car;

class ParkingCreate extends Component
{
    public $car_id, $placa, $data_hora_entrada, $data_hora_saida, $valor, $plano;
    public $fabricantes = [];
    public $modelos = [];
    public $car_fabricante;
    public $car_modelo;
    public $tipo;
    public bool $confirmingSave = false;
    public $tipos = [
        ['id' => 1, 'name' => 'Veículo Pequeno'],
        ['id' => 2, 'name' => 'Veículo Grande'],
    ];

    public function mount()
    {
        $this->data_hora_entrada = now()->format('Y-m-d\TH:i');
        $this->fabricantes = Car::distinct('fabricante')
            ->get(['fabricante'])
            ->map(function ($item) {
                return [
                    'id' => $item->fabricante,
                    'name' => $item->fabricante,
                ];
            })
            ->toArray();
    }

    public function carregarModelos($fabricante)
    {
        if (!$fabricante) {
            $this->modelos = [];
            return;
        }

        $this->modelos = Car::where('fabricante', $fabricante)
            ->get(['id', 'modelo'])
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->modelo,
                ];
            })
            ->toArray();

        $this->car_modelo = null;
        $this->tipo = null;
    }

    public function carregarTipos($modelo)
    {
        if (!$modelo) {
            $this->tipo = null;
            return;
        }

        $car = Car::find($modelo);
        if ($car) {
            $this->tipo = $car->tipo; // Carrega o tipo atual do modelo
        } else {
            $this->tipo = null;
        }
    }



    public function confirmSave()
    {
        $this->validate([
            'car_modelo' => 'required|exists:car,id',
            'placa' => 'required|max:7',
            'data_hora_entrada' => 'required|date',
            'plano' => 'nullable|integer',
        ]);

        $this->confirmingSave = true;
    }

    public function printAndSave()
    {
        try {
            // Valida antes de salvar
            $this->validate([
                'car_modelo' => 'required|exists:car,id',
                'placa' => 'required|max:7',
                'data_hora_entrada' => 'required|date',
                'plano' => 'nullable|integer',
                'tipo' => 'required|integer', // Valida o tipo
            ]);

            // Prepara os dados para salvar
            $this->car_id = $this->car_modelo;
            $this->placa = strtoupper($this->placa);

            // Atualiza o tipo no modelo do carro
            $car = Car::find($this->car_modelo);
            if ($car) {
                $car->update(['tipo' => $this->tipo]);
            }

            // Salva os dados
            Parking::create([
                'car_id' => $this->car_id,
                'placa' => $this->placa,
                'data_hora_entrada' => $this->data_hora_entrada,
                'data_hora_saida' => $this->data_hora_saida,
                'valor' => $this->valor,
                'plano' => $this->plano,
            ]);

            // Fecha o modal
            $this->confirmingSave = false;

            // Dispara a impressão
            $this->dispatch('print-comprovante');

            // Mostra mensagem de sucesso
            session()->flash('success', 'Registro criado com sucesso!');

            // Redireciona após a impressão (o redirecionamento será tratado pelo JavaScript)

        } catch (\Exception $e) {
            $this->addError('saveError', 'Erro ao salvar: '.$e->getMessage());
        }
    }

    public function getFabricanteName()
    {
        if (empty($this->car_fabricante)) {
            return 'Não selecionado';
        }

        // Para arrays normais (não collections)
        foreach ($this->fabricantes as $fabricante) {
            if ($fabricante['id'] == $this->car_fabricante) {
                return $fabricante['name'];
            }
        }

        return 'Fabricante não encontrado';
    }

    public function getModeloName()
    {
        if (!$this->car_modelo) return 'Não selecionado';

        $car = Car::find($this->car_modelo);
        return $car ? $car->modelo : 'Modelo não encontrado';
    }

    public function render()
    {
        return view('livewire.parking.create');
    }
}
