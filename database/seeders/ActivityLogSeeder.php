<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ActivityLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $activityLogs = [
            // ACTIVIDADES DE USUARIOS
            [
                'user_id' => 5, // Laura Sofía
                'action' => 'user_login',
                'description' => 'Inicio de sesión exitoso',
                'created_at' => Carbon::now()->subHours(2),
                'updated_at' => Carbon::now()->subHours(2),
            ],
            [
                'user_id' => 6, // David Andrés
                'action' => 'post_view',
                'description' => 'Vió el artículo sobre Semana Santa',
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ],
            [
                'user_id' => 3, // Carlos Mendoza
                'action' => 'product_create',
                'description' => 'Publicó nueva obra "Paisaje del Puente del Humilladero"',
                'created_at' => Carbon::now()->subDays(15),
                'updated_at' => Carbon::now()->subDays(15),
            ],
            [
                'user_id' => 2, // María Fernanda
                'action' => 'event_attendance',
                'description' => 'Confirmó asistencia al taller de tejido',
                'created_at' => Carbon::now()->subDays(7),
                'updated_at' => Carbon::now()->subDays(7),
            ],
            [
                'user_id' => 4, // Ana Lucía
                'action' => 'post_comment',
                'description' => 'Comentó en la convocatoria del Festival de Arte Joven',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'user_id' => 1, // Administrador
                'action' => 'user_registration',
                'description' => 'Nuevo usuario registrado: Laura Sofía Gutiérrez',
                'created_at' => Carbon::now()->subDays(70),
                'updated_at' => Carbon::now()->subDays(70),
            ],
            [
                'user_id' => 1, // Administrador
                'action' => 'content_published',
                'description' => 'Publicó contenido destacado sobre patrimonio cultural',
                'created_at' => Carbon::now()->subDays(20),
                'updated_at' => Carbon::now()->subDays(20),
            ],
            [
                'user_id' => 6, // David Andrés
                'action' => 'order_created',
                'description' => 'Realizó pedido de obra artística',
                'created_at' => Carbon::now()->subDays(15),
                'updated_at' => Carbon::now()->subDays(15),
            ],
            [
                'user_id' => 5, // Laura Sofía
                'action' => 'profile_updated',
                'description' => 'Actualizó información de perfil',
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(10),
            ],
            [
                'user_id' => 3, // Carlos Mendoza
                'action' => 'social_interaction',
                'description' => 'Respondió comentario de seguidor',
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ]
        ];

        foreach ($activityLogs as $log) {
            DB::table('activity_logs')->insert($log);
        }

        $this->command->info('✅ ActivityLogSeeder ejecutado correctamente. 10 logs de actividad creados.');
    }
}