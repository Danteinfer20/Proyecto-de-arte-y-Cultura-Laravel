<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contentTypes = [
            [
                'name' => 'artículo',
                'description' => 'Contenido cultural informativo sobre tradiciones, historia y arte de Popayán',
                'allows_events' => false,
                'icon' => '📝',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'evento', 
                'description' => 'Eventos culturales, festivales, presentaciones y actividades en Popayán',
                'allows_events' => true,
                'icon' => '🎭',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'galería',
                'description' => 'Galerías de imágenes y obras de arte de artistas popayanejos',
                'allows_events' => false,
                'icon' => '🖼️',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'educativo',
                'description' => 'Contenido educativo, tutoriales y guías sobre arte y cultura',
                'allows_events' => false,
                'icon' => '📚',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'perfil_artista',
                'description' => 'Perfiles y biografías de artistas y gestores culturales de Popayán',
                'allows_events' => false,
                'icon' => '👨‍🎨',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'noticia',
                'description' => 'Noticias y novedades del sector cultural de Popayán',
                'allows_events' => false,
                'icon' => '📢',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($contentTypes as $type) {
            DB::table('content_types')->insert($type);
        }

        $this->command->info('✅ ContentTypeSeeder ejecutado correctamente. 6 tipos de contenido creados.');
    }
}
