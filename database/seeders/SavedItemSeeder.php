<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SavedItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $savedItems = [
            // LAURA SOFÍA - FAVORITOS E INSPIRACIÓN
            [
                'user_id' => 5, // Laura Sofía (ID REAL: 5)
                'post_id' => 1, // Semana Santa
                'category' => 'favorites',
                'created_at' => Carbon::now()->subDays(15),
                'updated_at' => Carbon::now()->subDays(15),
            ],
            [
                'user_id' => 5, // Laura Sofía (ID REAL: 5)
                'post_id' => 4, // Técnicas Tejido
                'category' => 'inspiration',
                'created_at' => Carbon::now()->subDays(12),
                'updated_at' => Carbon::now()->subDays(12),
            ],
            [
                'user_id' => 5, // Laura Sofía (ID REAL: 5)
                'post_id' => 3, // Festival Arte Joven
                'category' => 'read_later',
                'created_at' => Carbon::now()->subDays(8),
                'updated_at' => Carbon::now()->subDays(8),
            ],

            // DAVID ANDRÉS - LECTURA E INSPIRACIÓN
            [
                'user_id' => 6, // David Andrés (ID REAL: 6)
                'post_id' => 1, // Semana Santa
                'category' => 'read_later',
                'created_at' => Carbon::now()->subDays(14),
                'updated_at' => Carbon::now()->subDays(14),
            ],
            [
                'user_id' => 6, // David Andrés (ID REAL: 6)
                'post_id' => 2, // Carlos Mendoza
                'category' => 'inspiration',
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(10),
            ],
            [
                'user_id' => 6, // David Andrés (ID REAL: 6)
                'post_id' => 4, // Técnicas Tejido
                'category' => 'favorites',
                'created_at' => Carbon::now()->subDays(7),
                'updated_at' => Carbon::now()->subDays(7),
            ],

            // MARÍA FERNANDA - INSPIRACIÓN PROFESIONAL
            [
                'user_id' => 2, // María Fernanda (ID REAL: 2)
                'post_id' => 4, // Técnicas Tejido (su propio post)
                'category' => 'favorites',
                'created_at' => Carbon::now()->subDays(20),
                'updated_at' => Carbon::now()->subDays(20),
            ],
            [
                'user_id' => 2, // María Fernanda (ID REAL: 2)
                'post_id' => 2, // Carlos Mendoza
                'category' => 'inspiration',
                'created_at' => Carbon::now()->subDays(18),
                'updated_at' => Carbon::now()->subDays(18),
            ],

            // CARLOS MENDOZA - REFERENCIAS ARTÍSTICAS
            [
                'user_id' => 3, // Carlos Mendoza (ID REAL: 3)
                'post_id' => 1, // Semana Santa
                'category' => 'inspiration',
                'created_at' => Carbon::now()->subDays(16),
                'updated_at' => Carbon::now()->subDays(16),
            ],
            [
                'user_id' => 3, // Carlos Mendoza (ID REAL: 3)
                'post_id' => 4, // Técnicas Tejido
                'category' => 'read_later',
                'created_at' => Carbon::now()->subDays(13),
                'updated_at' => Carbon::now()->subDays(13),
            ],

            // ANA LUCÍA - GESTIÓN CULTURAL
            [
                'user_id' => 4, // Ana Lucía (ID REAL: 4)
                'post_id' => 3, // Festival Arte Joven (su propio evento)
                'category' => 'favorites',
                'created_at' => Carbon::now()->subDays(11),
                'updated_at' => Carbon::now()->subDays(11),
            ],
            [
                'user_id' => 4, // Ana Lucía (ID REAL: 4)
                'post_id' => 1, // Semana Santa
                'category' => 'read_later',
                'created_at' => Carbon::now()->subDays(9),
                'updated_at' => Carbon::now()->subDays(9),
            ],

            // ADMINISTRADOR - CONTENIDO DESTACADO
            [
                'user_id' => 1, // Administrador (ID REAL: 1)
                'post_id' => 1, // Semana Santa
                'category' => 'favorites',
                'created_at' => Carbon::now()->subDays(25),
                'updated_at' => Carbon::now()->subDays(25),
            ],
            [
                'user_id' => 1, // Administrador (ID REAL: 1)
                'post_id' => 2, // Carlos Mendoza
                'category' => 'inspiration',
                'created_at' => Carbon::now()->subDays(22),
                'updated_at' => Carbon::now()->subDays(22),
            ],
            [
                'user_id' => 1, // Administrador (ID REAL: 1)
                'post_id' => 3, // Festival Arte Joven
                'category' => 'read_later',
                'created_at' => Carbon::now()->subDays(19),
                'updated_at' => Carbon::now()->subDays(19),
            ]
        ];

        foreach ($savedItems as $savedItem) {
            DB::table('saved_items')->insert($savedItem);
        }

        $this->command->info('✅ SavedItemSeeder ejecutado correctamente. 15 elementos guardados creados.');
    }
}