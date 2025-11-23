<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orderItems = [
    // ITEMS PARA ORDEN 2 (Laura Sofía - Total: 160,000)
    [
        'order_id' => 2,  // ✅ CORREGIDO (era 1)
        'product_id' => 1, // Mochila Guambiana
        'quantity' => 1,
        'price' => 75000.00,
        'created_at' => Carbon::now()->subDays(25),
        'updated_at' => Carbon::now()->subDays(25),
    ],
    [
        'order_id' => 2,  // ✅ CORREGIDO (era 1)
        'product_id' => 2, // Chumbe de Lana
        'quantity' => 1,
        'price' => 45000.00,
        'created_at' => Carbon::now()->subDays(25),
        'updated_at' => Carbon::now()->subDays(25),
    ],
    [
        'order_id' => 2,  // ✅ CORREGIDO (era 1)
        'product_id' => 6, // Guía Patrimonio
        'quantity' => 1,
        'price' => 35000.00,
        'created_at' => Carbon::now()->subDays(25),
        'updated_at' => Carbon::now()->subDays(25),
    ],

    // ITEMS PARA ORDEN 3 (David Andrés - Total: 250,000)
    [
        'order_id' => 3,  // ✅ CORREGIDO (era 2)
        'product_id' => 4, // Serie Procesión Nocturna
        'quantity' => 1,
        'price' => 250000.00,
        'created_at' => Carbon::now()->subDays(15),
        'updated_at' => Carbon::now()->subDays(15),
    ],

    // ITEMS PARA ORDEN 4 (Administrador - Total: 180,000)
    [
        'order_id' => 4,  // ✅ CORREGIDO (era 3)
        'product_id' => 3, // Paisaje Puente Humilladero
        'quantity' => 1,
        'price' => 980000.00,
        'created_at' => Carbon::now()->subDays(10),
        'updated_at' => Carbon::now()->subDays(10),
    ],
    [
        'order_id' => 4,  // ✅ CORREGIDO (era 3)
        'product_id' => 5, // Kit de Teatro
        'quantity' => 1,
        'price' => 65000.00,
        'created_at' => Carbon::now()->subDays(10),
        'updated_at' => Carbon::now()->subDays(10),
    ],

    // ITEMS PARA ORDEN 5 (Ana Lucía - Total: 65,000)
    [
        'order_id' => 5,  // ✅ CORREGIDO (era 4)
        'product_id' => 5, // Kit de Teatro
        'quantity' => 1,
        'price' => 65000.00,
        'created_at' => Carbon::now()->subDays(5),
        'updated_at' => Carbon::now()->subDays(5),
    ],

    // ITEMS PARA ORDEN 6 (Carlos Mendoza - Total: 35,000)
    [
        'order_id' => 6,  // ✅ CORREGIDO (era 5)
        'product_id' => 6, // Guía Patrimonio
        'quantity' => 1,
        'price' => 35000.00,
        'created_at' => Carbon::now()->subDays(30),
        'updated_at' => Carbon::now()->subDays(30),
    ]
        ];

        foreach ($orderItems as $item) {
            DB::table('order_items')->insert($item);
        }

        $this->command->info('✅ OrderItemSeeder ejecutado correctamente. 8 items de órdenes creados.');
    }
}