<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reactions = [
            // REACCIONES EN POST 1: Semana Santa
            [
                'post_id' => 1,
                'user_id' => 5, // Laura Sofía (ID REAL: 5)
                'reaction_type' => 'love',
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(10),
            ],
            [
                'post_id' => 1,
                'user_id' => 6, // David Andrés (ID REAL: 6)
                'reaction_type' => 'inspire',
                'created_at' => Carbon::now()->subDays(9),
                'updated_at' => Carbon::now()->subDays(9),
            ],
            [
                'post_id' => 1,
                'user_id' => 2, // María Fernanda (ID REAL: 2)
                'reaction_type' => 'like',
                'created_at' => Carbon::now()->subDays(8),
                'updated_at' => Carbon::now()->subDays(8),
            ],
            [
                'post_id' => 1,
                'user_id' => 1, // Administrador (ID REAL: 1)
                'reaction_type' => 'love',
                'created_at' => Carbon::now()->subDays(7),
                'updated_at' => Carbon::now()->subDays(7),
            ],

            // REACCIONES EN POST 2: Carlos Mendoza
            [
                'post_id' => 2,
                'user_id' => 6, // David Andrés (ID REAL: 6)
                'reaction_type' => 'interest',
                'created_at' => Carbon::now()->subDays(6),
                'updated_at' => Carbon::now()->subDays(6),
            ],
            [
                'post_id' => 2,
                'user_id' => 5, // Laura Sofía (ID REAL: 5)
                'reaction_type' => 'like',
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'post_id' => 2,
                'user_id' => 4, // Ana Lucía (ID REAL: 4)
                'reaction_type' => 'inspire',
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subDays(4),
            ],

            // REACCIONES EN POST 3: Festival Arte Joven
            [
                'post_id' => 3,
                'user_id' => 5, // Laura Sofía (ID REAL: 5)
                'reaction_type' => 'interest',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'post_id' => 3,
                'user_id' => 2, // María Fernanda (ID REAL: 2)
                'reaction_type' => 'inspire',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'post_id' => 3,
                'user_id' => 3, // Carlos Mendoza (ID REAL: 3)
                'reaction_type' => 'like',
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ],

            // REACCIONES EN POST 4: Técnicas Tejido
            [
                'post_id' => 4,
                'user_id' => 2, // María Fernanda (ID REAL: 2)
                'reaction_type' => 'love',
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'post_id' => 4,
                'user_id' => 5, // Laura Sofía (ID REAL: 5)
                'reaction_type' => 'inspire',
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subDays(4),
            ],
            [
                'post_id' => 4,
                'user_id' => 4, // Ana Lucía (ID REAL: 4)
                'reaction_type' => 'interest',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'post_id' => 4,
                'user_id' => 1, // Administrador (ID REAL: 1)
                'reaction_type' => 'like',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ]
        ];

        foreach ($reactions as $reaction) {
            DB::table('reactions')->insert($reaction);
        }

        $this->command->info('✅ ReactionSeeder ejecutado correctamente. 14 reacciones sociales creadas.');
    }
}