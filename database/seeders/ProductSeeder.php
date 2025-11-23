<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // PRODUCTOS DE MARÍA FERNANDA (ARTESANA)
            [
                'user_id' => 2, // María Fernanda López (ID REAL: 2)
                'category_id' => 3, // Artesanías
                'name' => 'Mochila Guambiana Tradicional',
                'description' => 'Hermosa mochila tejida a mano con lana de oveja y tintes naturales, utilizando la técnica ancestral de la guanga. Cada patrón representa elementos de la cosmovisión indígena del Cauca.',
                'price' => 85000.00,
                'sale_price' => 75000.00,
                'stock_quantity' => 5,
                'product_type' => 'handicraft',
                'dimensions' => '30x25 cm',
                'materials' => 'Lana de oveja, tintes naturales de achiote y nogal',
                'weight_kg' => 0.45,
                'main_image' => null,
                'status' => 'available',
                'is_featured' => true,
                'sales_count' => 3,
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(5),
            ],

            [
                'user_id' => 2, // María Fernanda López (ID REAL: 2)
                'category_id' => 3, // Artesanías
                'name' => 'Chumbe de Lana Natural',
                'description' => 'Faja tradicional tejida en telar de cintura, utilizada en las comunidades indígenas del Cauca. Ideal como pieza decorativa o accesorio cultural.',
                'price' => 45000.00,
                'sale_price' => null,
                'stock_quantity' => 8,
                'product_type' => 'handicraft',
                'dimensions' => '200x15 cm',
                'materials' => 'Lana natural, algodón',
                'weight_kg' => 0.25,
                'main_image' => null,
                'status' => 'available',
                'is_featured' => false,
                'sales_count' => 7,
                'created_at' => Carbon::now()->subDays(45),
                'updated_at' => Carbon::now()->subDays(10),
            ],

            // PRODUCTOS DE CARLOS MENDOZA (PINTOR)
            [
                'user_id' => 3, // Carlos Arturo Mendoza (ID REAL: 3)
                'category_id' => 1, // Artes Visuales
                'name' => 'Paisaje del Puente del Humilladero',
                'description' => 'Pintura al óleo que captura la belleza del emblemático Puente del Humilladero al atardecer. Obra original firmada por el artista.',
                'price' => 1200000.00,
                'sale_price' => 980000.00,
                'stock_quantity' => 1,
                'product_type' => 'physical',
                'dimensions' => '60x40 cm',
                'materials' => 'Óleo sobre lienzo, marco de madera',
                'weight_kg' => 2.5,
                'main_image' => null,
                'status' => 'available',
                'is_featured' => true,
                'sales_count' => 0,
                'created_at' => Carbon::now()->subDays(15),
                'updated_at' => Carbon::now()->subDays(2),
            ],

            [
                'user_id' => 3, // Carlos Arturo Mendoza (ID REAL: 3)
                'category_id' => 1, // Artes Visuales
                'name' => 'Serie Limitada: Procesión Nocturna',
                'description' => 'Reproducción numerada y firmada de la obra "Procesión Nocturna en Popayán". Edición limitada a 50 copias.',
                'price' => 250000.00,
                'sale_price' => null,
                'stock_quantity' => 12,
                'product_type' => 'physical',
                'dimensions' => '40x30 cm',
                'materials' => 'Impresión giclée en papel de algodón',
                'weight_kg' => 0.8,
                'main_image' => null,
                'status' => 'available',
                'is_featured' => false,
                'sales_count' => 8,
                'created_at' => Carbon::now()->subDays(60),
                'updated_at' => Carbon::now()->subDays(15),
            ],

            // PRODUCTO DE ANA LUCÍA (GESTORA CULTURAL)
            [
                'user_id' => 4, // Ana Lucía Torres (ID REAL: 4)
                'category_id' => 2, // Artes Escénicas
                'name' => 'Kit de Iniciación al Teatro',
                'description' => 'Kit educativo que incluye guía de actuación básica, ejercicios de expresión corporal y acceso a video tutoriales sobre técnicas teatrales.',
                'price' => 75000.00,
                'sale_price' => 65000.00,
                'stock_quantity' => 20,
                'product_type' => 'digital',
                'dimensions' => null,
                'materials' => 'Guía impresa, acceso digital',
                'weight_kg' => 0.3,
                'main_image' => null,
                'status' => 'available',
                'is_featured' => true,
                'sales_count' => 15,
                'created_at' => Carbon::now()->subDays(25),
                'updated_at' => Carbon::now()->subDays(3),
            ],

            // PRODUCTO DE ADMINISTRADOR
            [
                'user_id' => 1, // Administrador Cultural (ID REAL: 1)
                'category_id' => 4, // Patrimonio Cultural
                'name' => 'Guía del Patrimonio de Popayán',
                'description' => 'Guía completa sobre el patrimonio arquitectónico y cultural de Popayán, incluye mapa histórico y fichas técnicas de los principales monumentos.',
                'price' => 35000.00,
                'sale_price' => null,
                'stock_quantity' => 50,
                'product_type' => 'physical',
                'dimensions' => '21x15 cm',
                'materials' => 'Papel reciclado, tinta ecológica',
                'weight_kg' => 0.15,
                'main_image' => null,
                'status' => 'available',
                'is_featured' => false,
                'sales_count' => 22,
                'created_at' => Carbon::now()->subDays(90),
                'updated_at' => Carbon::now()->subDays(20),
            ]
        ];

        foreach ($products as $product) {
            DB::table('products')->insert($product);
        }

        $this->command->info('✅ ProductSeeder ejecutado correctamente. 6 productos culturales creados.');
    }
}