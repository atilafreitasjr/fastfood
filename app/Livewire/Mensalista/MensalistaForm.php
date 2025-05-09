<?php

namespace App\Livewire\Mensalista;

use Livewire\Component;
use App\Models\Mensalista;

class MensalistaForm extends Component
{
    public $mensalista;
    public $nome;
    public $email;
    public $cpf;
    public $rg;
    public $data_nascimento;

    protected $rules = [
        'nome' => 'required|min:3',
        'email' => 'nullable|email',
        'cpf' => 'required|formato_cpf|unique:mensalistas,cpf',
        'rg' => 'nullable',
        'data_nascimento' => 'nullable|date',
    ];

    public function mount($mensalista = null)
    {
        if ($mensalista) {
            $this->mensalista = Mensalista::findOrFail($mensalista);
            $this->nome = $this->mensalista->nome;
            $this->email = $this->mensalista->email;
            $this->cpf = $this->mensalista->cpf;
            $this->rg = $this->mensalista->rg;
            $this->data_nascimento = $this->mensalista->data_nascimento;
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'nome' => $this->nome,
            'email' => $this->email,
            'cpf' => $this->cpf,
            'rg' => $this->rg,
            'data_nascimento' => $this->data_nascimento,
        ];

        if ($this->mensalista) {
            $this->mensalista->update($data);
            session()->flash('success', 'Mensalista atualizado com sucesso!');
        } else {
            Mensalista::create($data);
            session()->flash('success', 'Mensalista criado com sucesso!');
        }

        return redirect()->route('mensalista.index');
    }

    public function render()
    {
        return view('livewire.mensalista.form');
    }
}
