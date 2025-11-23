<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productImages = [
            // IMÁGENES PARA MOCHILA GUAMBIANA (Producto ID 1 - María Fernanda)
            [
                'product_id' => 1,
                'image_path' => 'products/mochila-guambiana-1.jpg',
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(30),
            ],
            [
                'product_id' => 1,
                'image_path' => 'products/mochila-guambiana-2.jpg',
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(30),
            ],
            [
                'product_id' => 1,
                'image_path' => 'products/mochila-guambiana-detail.jpg',
                'created_at' => Carbon::now()->subDays(29),
                'updated_at' => Carbon::now()->subDays(29),
            ],

            // IMÁGENES PARA CHUMBE DE LANA (Producto ID 2 - María Fernanda)
            [
                'product_id' => 2,
                'image_path' => 'products/chumbe-lana-1.jpg',
                'created_at' => Carbon::now()->subDays(45),
                'updated_at' => Carbon::now()->subDays(45),
            ],
            [
                'product_id' => 2,
                'image_path' => 'products/chumbe-lana-pattern.jpg',
                'created_at' => Carbon::now()->subDays(44),
                'updated_at' => Carbon::now()->subDays(44),
            ],

            // IMÁGENES PARA PAISAJE PUENTE HUMILLADERO (Producto ID 3 - Carlos Mendoza)
            [
                'product_id' => 3,
                'image_path' => 'products/puente-humilladero-1.jpg',
                'created_at' => Carbon::now()->subDays(15),
                'updated_at' => Carbon::now()->subDays(15),
            ],
            [
                'product_id' => 3,
                'image_path' => 'products/puente-humilladero-detail.jpg',
                'created_at' => Carbon::now()->subDays(14),
                'updated_at' => Carbon::now()->subDays(14),
            ],

            // IMÁGENES PARA SERIE PROCESIÓN NOCTURNA (Producto ID 4 - Carlos Mendoza)
            [
                'product_id' => 4,
                'image_path' => 'products/procesion-nocturna-1.jpg',
                'created_at' => Carbon::now()->subDays(60),
                'updated_at' => Carbon::now()->subDays(60),
            ],
            [
                'product_id' => 4,
                'image_path' => 'products/procesion-nocturna-certificate.jpg',
                'created_at' => Carbon::now()->subDays(59),
                'updated_at' => Carbon::now()->subDays(59),
            ],

            // IMÁGENES PARA KIT TEATRO (Producto ID 5 - Ana Lucía)
            [
                'product_id' => 5,
                'image_path' => 'products/kit-teatro-1.jpg',
                'created_at' => Carbon::now()->subDays(25),
                'updated_at' => Carbon::now()->subDays(25),
            ],
            [
                'product_id' => 5,
                'image_path' => 'products/kit-teatro-content.jpg',
                'created_at' => Carbon::now()->subDays(24),
                'updated_at' => Carbon::now()->subDays(24),
            ],

            // IMÁGENES PARA GUÍA PATRIMONIO (Producto ID 6 - Administrador)
            [
                'product_id' => 6,
                'image_path' => 'products/guia-patrimonio-cover.jpg',
                'created_at' => Carbon::now()->subDays(90),
                'updated_at' => Carbon::now()->subDays(90),
            ],
            [
                'product_id' => 6,
                'image_path' => 'products/guia-patrimonio-sample.jpg',
                'created_at' => Carbon::now()->subDays(89),
                'updated_at' => Carbon::now()->subDays(89),
            ]
        ];

        foreach ($productImages as $image) {
            DB::table('product_images')->insert($image);
        }

        $this->command->info('✅ ProductImageSeeder ejecutado correctamente. 12 imágenes de productos creadas.');
    }
}