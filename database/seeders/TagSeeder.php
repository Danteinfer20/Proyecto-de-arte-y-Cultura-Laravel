<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            [
                'name' => 'Artesanías Tradicionales',
                'slug' => 'artesanias-tradicionales',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Patrimonio UNESCO',
                'slug' => 'patrimonio-unesco',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Artistas Popayán',
                'slug' => 'artistas-popayan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Eventos Culturales',
                'slug' => 'eventos-culturales',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Educación Artística',
                'slug' => 'educacion-artistica',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Exposiciones',
                'slug' => 'exposiciones',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Técnicas Ancestrales',
                'slug' => 'tecnicas-ancestrales',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tejido Guanga',
                'slug' => 'tejido-guanga',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pintura Paisajista',
                'slug' => 'pintura-paisajista',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Festivales',
                'slug' => 'festivales',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gastronomía Caucana',
                'slug' => 'gastronomia-caucana',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Talleres Culturales',
                'slug' => 'talleres-culturales',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($tags as $tag) {
            DB::table('tags')->insert($tag);
        }

        $this->command->info('✅ TagSeeder ejecutado correctamente. 12 tags culturales creados.');
    }
}