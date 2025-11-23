<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userSettings = [
            // Administrador Cultural (ID 1)
            [
                'user_id' => 1,
                'email_notifications' => true,
                'push_notifications' => true,
                'new_followers_notify' => true,
                'comments_notify' => true,
                'nearby_events_notify' => false,
                'public_profile' => true,
                'language' => 'es',
                'theme' => 'dark',
                'created_at' => Carbon::now()->subDays(90),
                'updated_at' => Carbon::now()->subDays(10),
            ],
            // María Fernanda López - Artesana (ID 2)
            [
                'user_id' => 2,
                'email_notifications' => true,
                'push_notifications' => true,
                'new_followers_notify' => true,
                'comments_notify' => true,
                'nearby_events_notify' => true,
                'public_profile' => true,
                'language' => 'es',
                'theme' => 'light',
                'created_at' => Carbon::now()->subDays(85),
                'updated_at' => Carbon::now()->subDays(15),
            ],
            // Carlos Arturo Mendoza - Pintor (ID 3)
            [
                'user_id' => 3,
                'email_notifications' => true,
                'push_notifications' => false,
                'new_followers_notify' => true,
                'comments_notify' => true,
                'nearby_events_notify' => false,
                'public_profile' => true,
                'language' => 'es',
                'theme' => 'auto',
                'created_at' => Carbon::now()->subDays(80),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            // Ana Lucía Torres - Gestora Cultural (ID 4)
            [
                'user_id' => 4,
                'email_notifications' => true,
                'push_notifications' => true,
                'new_followers_notify' => true,
                'comments_notify' => false,
                'nearby_events_notify' => true,
                'public_profile' => true,
                'language' => 'es',
                'theme' => 'light',
                'created_at' => Carbon::now()->subDays(75),
                'updated_at' => Carbon::now()->subDays(20),
            ],
            // Laura Sofía Gutiérrez - Visitante (ID 5)
            [
                'user_id' => 5,
                'email_notifications' => true,
                'push_notifications' => true,
                'new_followers_notify' => true,
                'comments_notify' => true,
                'nearby_events_notify' => true,
                'public_profile' => false,
                'language' => 'es',
                'theme' => 'auto',
                'created_at' => Carbon::now()->subDays(70),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            // David Andrés Pérez - Visitante (ID 6)
            [
                'user_id' => 6,
                'email_notifications' => false,
                'push_notifications' => true,
                'new_followers_notify' => true,
                'comments_notify' => true,
                'nearby_events_notify' => true,
                'public_profile' => true,
                'language' => 'es',
                'theme' => 'dark',
                'created_at' => Carbon::now()->subDays(65),
                'updated_at' => Carbon::now()->subDays(8),
            ]
        ];

        foreach ($userSettings as $settings) {
            DB::table('user_settings')->insert($settings);
        }

        $this->command->info('✅ UserSettingsSeeder ejecutado correctamente. 6 configuraciones de usuario creadas.');
    }
}