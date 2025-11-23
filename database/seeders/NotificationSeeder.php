<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $notifications = [
            // NOTIFICACIONES PARA CARLOS MENDOZA (ID 3) - Artista popular
            [
                'user_id' => 3,
                'type' => 'new_follower',
                'title' => 'Nuevo seguidor',
                'message' => 'Laura Sofía Gutiérrez empezó a seguirte',
                'action_url' => '/users/5',
                'is_read' => true,
                'read_at' => Carbon::now()->subDays(25),
                'created_at' => Carbon::now()->subDays(26),
                'updated_at' => Carbon::now()->subDays(25),
            ],
            [
                'user_id' => 3,
                'type' => 'comment',
                'title' => 'Nuevo comentario',
                'message' => 'David Andrés Pérez comentó en tu perfil: "Admiro mucho tu obra..."',
                'action_url' => '/posts/2#comment-6',
                'is_read' => true,
                'read_at' => Carbon::now()->subDays(6),
                'created_at' => Carbon::now()->subDays(7),
                'updated_at' => Carbon::now()->subDays(6),
            ],
            [
                'user_id' => 3,
                'type' => 'reaction',
                'title' => 'Nueva reacción',
                'message' => 'Ana Lucía Torres reaccionó con "inspire" a tu publicación',
                'action_url' => '/posts/2',
                'is_read' => false,
                'read_at' => null,
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subDays(4),
            ],

            // NOTIFICACIONES PARA MARÍA FERNANDA (ID 2) - Artesana
            [
                'user_id' => 2,
                'type' => 'new_follower',
                'title' => 'Nuevo seguidor',
                'message' => 'Administrador Cultural empezó a seguirte',
                'action_url' => '/users/1',
                'is_read' => true,
                'read_at' => Carbon::now()->subDays(22),
                'created_at' => Carbon::now()->subDays(23),
                'updated_at' => Carbon::now()->subDays(22),
            ],
            [
                'user_id' => 2,
                'type' => 'comment',
                'title' => 'Nuevo comentario',
                'message' => 'Laura Sofía Gutiérrez preguntó sobre tus talleres de tejido',
                'action_url' => '/posts/4#comment-4',
                'is_read' => true,
                'read_at' => Carbon::now()->subDays(8),
                'created_at' => Carbon::now()->subDays(9),
                'updated_at' => Carbon::now()->subDays(8),
            ],

            // NOTIFICACIONES PARA LAURA SOFÍA (ID 5) - Visitante activa
            [
                'user_id' => 5,
                'type' => 'event_reminder',
                'title' => 'Recordatorio de evento',
                'message' => 'Tu taller de tejido con María Fernanda comienza en 2 días',
                'action_url' => '/events/3',
                'is_read' => false,
                'read_at' => null,
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ],
            [
                'user_id' => 5,
                'type' => 'new_follower',
                'title' => 'Nuevo seguidor',
                'message' => 'David Andrés Pérez empezó a seguirte',
                'action_url' => '/users/6',
                'is_read' => true,
                'read_at' => Carbon::now()->subDays(6),
                'created_at' => Carbon::now()->subDays(7),
                'updated_at' => Carbon::now()->subDays(6),
            ],

            // NOTIFICACIONES PARA DAVID ANDRÉS (ID 6) - Visitante
            [
                'user_id' => 6,
                'type' => 'system',
                'title' => 'Nuevo contenido educativo',
                'message' => 'María Fernanda publicó nuevas técnicas de tejido tradicional',
                'action_url' => '/posts/4',
                'is_read' => false,
                'read_at' => null,
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],

            // NOTIFICACIONES PARA ANA LUCÍA (ID 4) - Gestora cultural
            [
                'user_id' => 4,
                'type' => 'comment',
                'title' => 'Nuevo comentario',
                'message' => 'Laura Sofía Gutiérrez quiere participar en el Festival de Arte Joven',
                'action_url' => '/posts/3#comment-8',
                'is_read' => true,
                'read_at' => Carbon::now()->subDays(4),
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(4),
            ],

            // NOTIFICACIONES PARA ADMINISTRADOR (ID 1)
            [
                'user_id' => 1,
                'type' => 'system',
                'title' => 'Resumen semanal',
                'message' => 'Esta semana tuviste 45 visitas nuevas y 3 publicaciones destacadas',
                'action_url' => '/admin/dashboard',
                'is_read' => false,
                'read_at' => null,
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ]
        ];

        foreach ($notifications as $notification) {
            DB::table('notifications')->insert($notification);
        }

        $this->command->info('✅ NotificationSeeder ejecutado correctamente. 10 notificaciones creadas.');
    }
}