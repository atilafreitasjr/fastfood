<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parking extends Model
{
    use HasFactory;

    protected $table = 'parking';

    protected $fillable = [
        'car_id',
        'placa',
        'data_hora_entrada',
        'data_hora_saida',
        'valor',
        'plano',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}