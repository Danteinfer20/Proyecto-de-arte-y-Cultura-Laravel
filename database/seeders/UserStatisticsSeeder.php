<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserStatisticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userStatistics = [
            // Administrador Cultural (ID 1)
            [
                'user_id' => 1,
                'post_count' => 1,
                'follower_count' => 3,
                'following_count' => 3,
                'event_count' => 1,
                'attendance_count' => 1,
                'average_rating' => 4.8,
                'sales_count' => 22,
                'total_revenue' => 770000.00,
                'created_at' => Carbon::now()->subDays(90),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            // María Fernanda López - Artesana (ID 2)
            [
                'user_id' => 2,
                'post_count' => 1,
                'follower_count' => 2,
                'following_count' => 2,
                'event_count' => 1,
                'attendance_count' => 0,
                'average_rating' => 4.9,
                'sales_count' => 10,
                'total_revenue' => 650000.00,
                'created_at' => Carbon::now()->subDays(85),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            // Carlos Arturo Mendoza - Pintor (ID 3)
            [
                'user_id' => 3,
                'post_count' => 1,
                'follower_count' => 4,
                'following_count' => 2,
                'event_count' => 1,
                'attendance_count' => 1,
                'average_rating' => 4.7,
                'sales_count' => 8,
                'total_revenue' => 2960000.00,
                'created_at' => Carbon::now()->subDays(80),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            // Ana Lucía Torres - Gestora Cultural (ID 4)
            [
                'user_id' => 4,
                'post_count' => 1,
                'follower_count' => 2,
                'following_count' => 0,
                'event_count' => 1,
                'attendance_count' => 2,
                'average_rating' => 4.6,
                'sales_count' => 15,
                'total_revenue' => 975000.00,
                'created_at' => Carbon::now()->subDays(75),
                'updated_at' => Carbon::now()->subDays(1),
            ],
            // Laura Sofía Gutiérrez - Visitante (ID 5)
            [
                'user_id' => 5,
                'post_count' => 0,
                'follower_count' => 1,
                'following_count' => 3,
                'event_count' => 0,
                'attendance_count' => 2,
                'average_rating' => 0.0,
                'sales_count' => 0,
                'total_revenue' => 0.00,
                'created_at' => Carbon::now()->subDays(70),
                'updated_at' => Carbon::now()->subDays(4),
            ],
            // David Andrés Pérez - Visitante (ID 6)
            [
                'user_id' => 6,
                'post_count' => 0,
                'follower_count' => 1,
                'following_count' => 2,
                'event_count' => 0,
                'attendance_count' => 1,
                'average_rating' => 0.0,
                'sales_count' => 0,
                'total_revenue' => 0.00,
                'created_at' => Carbon::now()->subDays(65),
                'updated_at' => Carbon::now()->subDays(6),
            ]
        ];

        foreach ($userStatistics as $statistics) {
            DB::table('user_statistics')->insert($statistics);
        }

        $this->command->info('✅ UserStatisticsSeeder ejecutado correctamente. 6 estadísticas de usuario creadas.');
    }
}