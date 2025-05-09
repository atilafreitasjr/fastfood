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
    public $car_tipo; // ID do tipo selecionado
    public $tempo_permanencia; // Tempo de permanência

    public function mount($id)
    {
        $parking = Parking::findOrFail($id);
        $this->parking_id = $parking->id;
        $this->car_id = $parking->car_id;
        $this->placa = $parking->placa;
        $this->data_hora_entrada = \Carbon\Carbon::parse($parking->data_hora_entrada)->format('d-m-Y H:i');
        $this->data_hora_saida = \Carbon\Carbon::now('America/Sao_Paulo')->format('d-m-Y H:i'); // Horário ajustado para Brasília
        $this->plano = $parking->plano;

        $car = Car::find($this->car_id);
        if ($car) {
            $this->car_fabricante = $car->fabricante;
            $this->car_modelo = $car->id;
            $this->car_tipo = $car->tipo;

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
        if ($dias > 0) {
            $this->tempo_permanencia = sprintf('%d dias, %02d:%02d', $dias, $horas, $minutos); // Formato "X dias, HH:MM"
        } else {
            $this->tempo_permanencia = sprintf('%02d:%02d', $horas, $minutos); // Formato "HH:MM"
        }

        // Inicializa o valor
        $this->valor = 0.00;

        // Se for mensalista, não cobra, o valor é acertado na mensalidade
        if ($this->plano > 0) {
            $this->tempo_permanencia = 'Mensalista';
            return;
        }

        if ($this->car_tipo == 2) {
             // Se o veículo for grande, aplica a tabela de preços para veículos grandes
             switch (true) {
                case ($diferencaMinutos > 240):
                    $this->valor = 16.00; // acima de 4 horas
                    break;
                case ($diferencaMinutos > 180):
                    $this->valor = 13.00; // acima de 3 horas
                    break;
                case ($diferencaMinutos > 120):
                    $this->valor = 12.00; // acima de 2 horas
                    break;
                case ($diferencaMinutos > 60):
                    $this->valor = 10.00; // acima de 1 hora
                    break;
                case ($diferencaMinutos > 30):
                    $this->valor = 8.00; // acima de 30 minutos
                    break;
                case ($diferencaMinutos > 5):
                    $this->valor = 5.00; // acima de 5 minutos
                    break;
                default:
                    $this->valor = 0.00; // abaixo de 5 minutos
                    break;
            }
        } else {
            // Se o veículo for pequeno, aplica a tabela de preços para veículos pequenos
            switch (true) {
                case ($diferencaMinutos > 240):
                    $this->valor = 14.00; // acima de 4 horas
                    break;
                case ($diferencaMinutos > 180):
                    $this->valor = 13.00; // acima de 3 horas
                    break;
                case ($diferencaMinutos > 120):
                    $this->valor = 12.00; // acima de 2 horas
                    break;
                case ($diferencaMinutos > 60):
                    $this->valor = 10.00; // acima de 1 hora
                    break;
                case ($diferencaMinutos > 30):
                    $this->valor = 8.00; // acima de 30 minutos
                    break;
                case ($diferencaMinutos > 5):
                    $this->valor = 4.00; // acima de 5 minutos
                    break;
                default:
                    $this->valor = 0.00; // abaixo de 5 minutos
                    break;
            }
        }

        // se a diária passar de um dia, cobrar as diárias
        if ($dias > 0) {
            if ($this->car_tipo == 2) {
                $this->valor += $dias * 16.00; // diárias para veículos grandes
            } else {
                $this->valor += $dias * 14.00; // diárias para veículos pequenos
            }
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
