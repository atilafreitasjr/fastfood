<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensalista extends Model
{
    use HasFactory;

    /**
     * Os campos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'nome',
        'email',
        'cpf',
        'rg',
        'data_nascimento',
    ];

    /**
     * Os campos que devem ser tratados como data.
     */
    protected $casts = [
        'data_nascimento' => 'date',
    ];

    /**
     * O nome da tabela associada ao modelo.
     */
    protected $table = 'mensalistas';
}
