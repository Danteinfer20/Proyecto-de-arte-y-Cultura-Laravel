<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PostTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $postTags = [
            // POST 1: Semana Santa - Patrimonio UNESCO
            [
                'post_id' => 1,
                'tag_id' => 2, // Patrimonio UNESCO
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'post_id' => 1,
                'tag_id' => 4, // Eventos Culturales
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'post_id' => 1,
                'tag_id' => 11, // Gastronomía Caucana
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // POST 2: Carlos Mendoza - Artista Popayán
            [
                'post_id' => 2,
                'tag_id' => 3, // Artistas Popayán
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'post_id' => 2,
                'tag_id' => 9, // Pintura Paisajista
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'post_id' => 2,
                'tag_id' => 6, // Exposiciones
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // POST 3: Festival Arte Joven - Eventos
            [
                'post_id' => 3,
                'tag_id' => 4, // Eventos Culturales
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'post_id' => 3,
                'tag_id' => 10, // Festivales
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'post_id' => 3,
                'tag_id' => 5, // Educación Artística
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // POST 4: Técnicas Tejido - Artesanías
            [
                'post_id' => 4,
                'tag_id' => 1, // Artesanías Tradicionales
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'post_id' => 4,
                'tag_id' => 7, // Técnicas Ancestrales
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'post_id' => 4,
                'tag_id' => 8, // Tejido Guanga
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'post_id' => 4,
                'tag_id' => 12, // Talleres Culturales
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($postTags as $postTag) {
            DB::table('post_tags')->insert($postTag);
        }

        $this->command->info('✅ PostTagsSeeder ejecutado correctamente. 13 relaciones posts-tags creadas.');
    }
}