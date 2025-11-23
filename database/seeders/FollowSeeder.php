<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FollowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $follows = [
            // SEGUIDORES DE ARTISTAS Y GESTORES CULTURALES
            
            // Carlos Mendoza (ID 3) - Artista popular
            [
                'follower_id' => 5, // Laura Sofía sigue a Carlos
                'followed_id' => 3,
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(30),
            ],
            [
                'follower_id' => 6, // David Andrés sigue a Carlos
                'followed_id' => 3,
                'created_at' => Carbon::now()->subDays(25),
                'updated_at' => Carbon::now()->subDays(25),
            ],
            [
                'follower_id' => 4, // Ana Lucía sigue a Carlos
                'followed_id' => 3,
                'created_at' => Carbon::now()->subDays(20),
                'updated_at' => Carbon::now()->subDays(20),
            ],

            // María Fernanda (ID 2) - Artesana
            [
                'follower_id' => 5, // Laura Sofía sigue a María
                'followed_id' => 2,
                'created_at' => Carbon::now()->subDays(28),
                'updated_at' => Carbon::now()->subDays(28),
            ],
            [
                'follower_id' => 1, // Administrador sigue a María
                'followed_id' => 2,
                'created_at' => Carbon::now()->subDays(22),
                'updated_at' => Carbon::now()->subDays(22),
            ],

            // Ana Lucía (ID 4) - Gestora cultural
            [
                'follower_id' => 5, // Laura Sofía sigue a Ana
                'followed_id' => 4,
                'created_at' => Carbon::now()->subDays(18),
                'updated_at' => Carbon::now()->subDays(18),
            ],
            [
                'follower_id' => 3, // Carlos Mendoza sigue a Ana
                'followed_id' => 4,
                'created_at' => Carbon::now()->subDays(15),
                'updated_at' => Carbon::now()->subDays(15),
            ],

            // SEGUIDORES MUTUOS ENTRE ARTISTAS
            [
                'follower_id' => 2, // María Fernanda sigue a Carlos
                'followed_id' => 3,
                'created_at' => Carbon::now()->subDays(12),
                'updated_at' => Carbon::now()->subDays(12),
            ],
            [
                'follower_id' => 3, // Carlos Mendoza sigue a María
                'followed_id' => 2,
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(10),
            ],

            // VISITANTES SE SIGUEN ENTRE SÍ
            [
                'follower_id' => 5, // Laura Sofía sigue a David
                'followed_id' => 6,
                'created_at' => Carbon::now()->subDays(8),
                'updated_at' => Carbon::now()->subDays(8),
            ],
            [
                'follower_id' => 6, // David Andrés sigue a Laura
                'followed_id' => 5,
                'created_at' => Carbon::now()->subDays(6),
                'updated_at' => Carbon::now()->subDays(6),
            ],

            // ADMINISTRADOR SIGUE A TODOS LOS CREADORES
            [
                'follower_id' => 1, // Administrador sigue a Ana
                'followed_id' => 4,
                'created_at' => Carbon::now()->subDays(24),
                'updated_at' => Carbon::now()->subDays(24),
            ],
            [
                'follower_id' => 1, // Administrador sigue a Carlos
                'followed_id' => 3,
                'created_at' => Carbon::now()->subDays(26),
                'updated_at' => Carbon::now()->subDays(26),
            ]
        ];

        foreach ($follows as $follow) {
            DB::table('follows')->insert($follow);
        }

        $this->command->info('✅ FollowSeeder ejecutado correctamente. 13 relaciones de seguimiento creadas.');
    }
}