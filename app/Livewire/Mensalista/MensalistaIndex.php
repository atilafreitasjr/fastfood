<?php

namespace App\Livewire\Mensalista;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Mensalista;

class MensalistaIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $mensalistas = Mensalista::when($this->search, function($query) {
            $query->where('nome', 'like', '%'.$this->search.'%')
                  ->orWhere('cpf', 'like', '%'.$this->search.'%');
        })
        ->orderBy('nome')
        ->paginate(10);

        return view('livewire.mensalista.index', compact('mensalistas'));
    }

    public function delete($id)
    {
        Mensalista::find($id)->delete();
        session()->flash('success', 'Mensalista removido com sucesso');
    }
}
