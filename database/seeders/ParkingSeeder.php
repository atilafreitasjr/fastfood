<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParkingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('parking')->insert([
        //     [
        //         'car_id' => 1,
        //         'placa' => 'ABC1234',
        //         'data_hora_entrada' => now(),
        //         'data_hora_saida' => null,
        //         'valor_cobrado' => null,
        //         'plano' => 1,
        //     ],
        //     [
        //         'car_id' => 2,
        //         'placa' => 'XYZ5678',
        //         'data_hora_entrada' => now(),
        //         'data_hora_saida' => now()->addHours(2),
        //         'valor_cobrado' => 20.00,
        //         'plano' => 2,
        //     ],
        // ]);
    }
}
