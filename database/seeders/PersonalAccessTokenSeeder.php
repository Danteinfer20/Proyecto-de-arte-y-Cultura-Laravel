<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PersonalAccessTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tokens = [
            // TOKEN PARA ADMINISTRADOR (ID 1) - Desarrollo
            [
                'tokenable_type' => 'App\Models\User',
                'tokenable_id' => 1,
                'name' => 'development-token',
                'token' => hash('sha256', 'admin_dev_token_2024'),
                'abilities' => json_encode(['*']),
                'last_used_at' => Carbon::now()->subDays(2),
                'created_at' => Carbon::now()->subDays(30),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            // TOKEN PARA CARLOS MENDOZA (ID 3) - App móvil
            [
                'tokenable_type' => 'App\Models\User',
                'tokenable_id' => 3,
                'name' => 'mobile-app',
                'token' => hash('sha256', 'carlos_mobile_token_2024'),
                'abilities' => json_encode(['posts:read', 'posts:write', 'products:manage']),
                'last_used_at' => Carbon::now()->subHours(6),
                'created_at' => Carbon::now()->subDays(15),
                'updated_at' => Carbon::now()->subHours(6),
            ],
            // TOKEN PARA MARÍA FERNANDA (ID 2) - App móvil
            [
                'tokenable_type' => 'App\Models\User',
                'tokenable_id' => 2,
                'name' => 'mobile-app',
                'token' => hash('sha256', 'maria_mobile_token_2024'),
                'abilities' => json_encode(['posts:read', 'posts:write', 'products:manage']),
                'last_used_at' => Carbon::now()->subDays(1),
                'created_at' => Carbon::now()->subDays(20),
                'updated_at' => Carbon::now()->subDays(1),
            ],
            // TOKEN PARA ANA LUCÍA (ID 4) - API externa
            [
                'tokenable_type' => 'App\Models\User',
                'tokenable_id' => 4,
                'name' => 'external-api',
                'token' => hash('sha256', 'ana_external_api_2024'),
                'abilities' => json_encode(['events:manage', 'posts:read']),
                'last_used_at' => Carbon::now()->subDays(3),
                'created_at' => Carbon::now()->subDays(25),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            // TOKEN PARA LAURA SOFÍA (ID 5) - App móvil
            [
                'tokenable_type' => 'App\Models\User',
                'tokenable_id' => 5,
                'name' => 'mobile-app',
                'token' => hash('sha256', 'laura_mobile_token_2024'),
                'abilities' => json_encode(['posts:read', 'comments:write', 'events:read']),
                'last_used_at' => Carbon::now()->subHours(12),
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subHours(12),
            ]
        ];

        foreach ($tokens as $token) {
            DB::table('personal_access_tokens')->insert($token);
        }

        $this->command->info('✅ PersonalAccessTokenSeeder ejecutado correctamente. 5 tokens de acceso creados.');
    }
}