<?php
namespace App\Livewire\Parking;

use App\Models\Parking;
use Livewire\Component;
use App\Models\Car;

class ParkingEdit extends Component
{
    public $parking_id, $car_id, $placa, $data_hora_entrada, $data_hora_saida, $valor, $plano;
    public $fabricantes = []; // Lista de fabricantes
    public $modelos = []; // Lista de modelos filtrados
    public $car_fabricante; // ID do fabricante selecionado
    public $car_modelo; // ID do modelo selecionado
    public $tempo_permanencia; // Tempo de permanência

    public function mount($id)
    {
        $parking = Parking::findOrFail($id);
        $this->parking_id = $parking->id;
        $this->car_id = $parking->car_id;
        $this->placa = $parking->placa;
        $this->data_hora_entrada = \Carbon\Carbon::parse($parking->data_hora_entrada)->format('Y-m-d H:i');
        $this->data_hora_saida = \Carbon\Carbon::now('America/Sao_Paulo')->format('Y-m-d H:i'); // Horário ajustado para Brasília
        $this->plano = $parking->plano;

        $car = Car::find($this->car_id);
        if ($car) {
            $this->car_fabricante = $car->fabricante;
            $this->car_modelo = $car->id;
        }

        $this->fabricantes = Car::distinct('fabricante')
            ->get(['fabricante'])
            ->map(function ($item) {
                return [
                    'id' => $item->fabricante,
                    'name' => $item->fabricante,
                ];
            })
            ->toArray();

        if ($this->car_fabricante) {
            $this->carregarModelos($this->car_fabricante);
        }

        $this->calcularValor(); // Calcula o valor inicial
    }

    public function carregarModelos($fabricante)
    {
        // Verificar se o fabricante foi selecionado
        if (!$fabricante) {
            $this->modelos = []; // Limpar os modelos se nenhum fabricante for selecionado
            return;
        }

        // Carregar os modelos com base no fabricante selecionado
        $this->modelos = Car::where('fabricante', $fabricante)
            ->get(['id', 'modelo'])
            ->map(function ($item) {
                return [
                    'id' => $item->id, // ID do modelo
                    'name' => $item->modelo, // Nome do modelo
                ];
            })
            ->toArray();
    }

    public function calcularValor()
    {
        $entrada = \Carbon\Carbon::parse($this->data_hora_entrada);
        $saida = \Carbon\Carbon::parse($this->data_hora_saida);

        // Calcula a diferença em minutos
        $diferencaMinutos = $entrada->diffInMinutes($saida);

        // Calcula o tempo de permanência em dias, horas e minutos
        $dias = intdiv($diferencaMinutos, 1440); // 1440 minutos em um dia
        $restoMinutos = $diferencaMinutos % 1440;
        $horas = intdiv($restoMinutos, 60);
        $minutos = $restoMinutos % 60;
        $this->tempo_permanencia = sprintf('%d dias, %02d:%02d', $dias, $horas, $minutos); // Formato "X dias, HH:MM"

        // Inicializa o valor
        $this->valor = 0.00;

        // Se for mensalista, não cobra, o valor é acertado na mensalidade
        if ($this->plano > 0) {
            $this->tempo_permanencia = 'Mensalista';
            return;
        }

        // Calcula o valor
        if ($diferencaMinutos >= 15) {
            $this->valor = 6.00; // Valor fixo para até 30 minutos
            dump('valor fixo:'.$this->valor);
        }

        if($diferencaMinutos > 30){
                $this->valor = $this->valor + ceil(($diferencaMinutos - 30) / 30) * 3.00; // R$ 6,00 + R$ 3,00 a cada 30 minutos adicionais
                dump('valor após 30min:'.$this->valor);
        }

        // Se o valor ultrapassar R$ 30,00, cobra-se R$ 30,00 para cada dia de permanência
        if ($this->valor > 30.00) {
            $this->valor = 30.00;
            dump('valor utrapassa 30 reais:'.$this->valor);
        }
        $dias = $entrada->diffInDays($saida);
        if ($dias > 1) {
            $this->valor = 30.00 * $dias;
            dump('valor após 1 dia:'.$this->valor);
            dump('dias:'.$dias);
        }
    }

    public function save()
    {
        $this->validate([
            'car_id' => 'required|exists:car,id',
            'placa' => 'required|max:7',
            'data_hora_entrada' => 'required|date',
            'data_hora_saida' => 'required|date',
            'valor' => 'required|numeric',
            'plano' => 'nullable|integer',
        ]);

        $parking = Parking::findOrFail($this->parking_id);
        $parking->update([
            'car_id' => $this->car_id,
            'placa' => $this->placa,
            'data_hora_entrada' => $this->data_hora_entrada,
            'data_hora_saida' => $this->data_hora_saida,
            'valor' => $this->valor,
            'plano' => $this->plano,
        ]);

        session()->flash('success', 'Registro atualizado com sucesso!');
        return redirect()->route('parking.index');
    }

    public function render()
    {
        return view('livewire.parking.edit');
    }
}
