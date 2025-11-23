<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = [
            // ORDEN 1: Laura Sofía compra productos artesanales
              [
        'user_id' => 5,
        'total' => 160000.00,
        'status' => 'completed',  // ✅ CORREGIDO
        'created_at' => Carbon::now()->subDays(25),
        'updated_at' => Carbon::now()->subDays(20),
    ],
    // ORDEN 2: David Andrés - PENDIENTE
    [
        'user_id' => 6,
        'total' => 250000.00,
        'status' => 'pending',    // ✅ CORREGIDO
        'created_at' => Carbon::now()->subDays(15),
        'updated_at' => Carbon::now()->subDays(12),
    ],
    // ORDEN 3: Administrador - COMPLETADA
    [
        'user_id' => 1,
        'total' => 180000.00,
        'status' => 'completed',  // ✅ CORREGIDO
        'created_at' => Carbon::now()->subDays(10),
        'updated_at' => Carbon::now()->subDays(8),
    ],
    // ORDEN 4: Ana Lucía - PENDIENTE
    [
        'user_id' => 4,
        'total' => 65000.00,
        'status' => 'pending',    // ✅ PERMITIDO
        'created_at' => Carbon::now()->subDays(5),
        'updated_at' => Carbon::now()->subDays(5),
    ],
    // ORDEN 5: Carlos Mendoza - COMPLETADA
    [
        'user_id' => 3,
        'total' => 35000.00,
        'status' => 'completed',  // ✅ CORREGIDO
        'created_at' => Carbon::now()->subDays(30),
        'updated_at' => Carbon::now()->subDays(25),
    ]
        ];

        foreach ($orders as $order) {
            DB::table('orders')->insert($order);
        }

        $this->command->info('✅ OrderSeeder ejecutado correctamente. 5 órdenes creadas.');
    }
}