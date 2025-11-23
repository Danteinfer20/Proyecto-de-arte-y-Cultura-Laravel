<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventAttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attendances = [
            // EVENTO 1: Exposición de Carlos Mendoza (ID 1)
            [
                'event_id' => 1,
                'user_id' => 5, // Laura Sofía - interesada
                'status' => 'interested',
                'guest_count' => 0,
                'qr_code' => 'EVT1-USER5-' . uniqid(),
                'checked_in' => false,
                'checked_in_at' => null,
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'event_id' => 1,
                'user_id' => 6, // David Andrés - confirmado
                'status' => 'confirmed',
                'guest_count' => 1,
                'qr_code' => 'EVT1-USER6-' . uniqid(),
                'checked_in' => false,
                'checked_in_at' => null,
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subDays(4),
            ],
            [
                'event_id' => 1,
                'user_id' => 4, // Ana Lucía - confirmada
                'status' => 'confirmed',
                'guest_count' => 0,
                'qr_code' => 'EVT1-USER4-' . uniqid(),
                'checked_in' => true,
                'checked_in_at' => Carbon::now()->subDays(1),
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(1),
            ],

            // EVENTO 2: Festival Arte Joven (ID 2)
            [
                'event_id' => 2,
                'user_id' => 5, // Laura Sofía - confirmada (participante)
                'status' => 'confirmed',
                'guest_count' => 0,
                'qr_code' => 'EVT2-USER5-' . uniqid(),
                'checked_in' => false,
                'checked_in_at' => null,
                'created_at' => Carbon::now()->subDays(6),
                'updated_at' => Carbon::now()->subDays(6),
            ],
            [
                'event_id' => 2,
                'user_id' => 3, // Carlos Mendoza - interesado
                'status' => 'interested',
                'guest_count' => 0,
                'qr_code' => 'EVT2-USER3-' . uniqid(),
                'checked_in' => false,
                'checked_in_at' => null,
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subDays(4),
            ],
            [
                'event_id' => 2,
                'user_id' => 2, // María Fernanda - no asistirá
                'status' => 'not_attending',
                'guest_count' => 0,
                'qr_code' => null,
                'checked_in' => false,
                'checked_in_at' => null,
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],

            // EVENTO 3: Taller de Tejido (ID 3) - Organizado por María Fernanda (user_id 2)
            [
                'event_id' => 3,
                'user_id' => 5, // Laura Sofía - confirmada (tomará el taller)
                'status' => 'confirmed',
                'guest_count' => 0,
                'qr_code' => 'EVT3-USER5-' . uniqid(),
                'checked_in' => true,
                'checked_in_at' => Carbon::now()->subHours(2),
                'created_at' => Carbon::now()->subDays(7),
                'updated_at' => Carbon::now()->subHours(2),
            ],
            [
                'event_id' => 3,
                'user_id' => 6, // David Andrés - interesado
                'status' => 'interested',
                'guest_count' => 0,
                'qr_code' => 'EVT3-USER6-' . uniqid(),
                'checked_in' => false,
                'checked_in_at' => null,
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'event_id' => 3,
                'user_id' => 1, // Administrador - confirmado
                'status' => 'confirmed',
                'guest_count' => 0,
                'qr_code' => 'EVT3-USER1-' . uniqid(),
                'checked_in' => true,
                'checked_in_at' => Carbon::now()->subHours(3),
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subHours(3),
            ],

            // EVENTO 4: Charla Semana Santa (ID 4)
            [
                'event_id' => 4,
                'user_id' => 6, // David Andrés - confirmado
                'status' => 'confirmed',
                'guest_count' => 1,
                'qr_code' => 'EVT4-USER6-' . uniqid(),
                'checked_in' => false,
                'checked_in_at' => null,
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'event_id' => 4,
                'user_id' => 3, // Carlos Mendoza - interesado
                'status' => 'interested',
                'guest_count' => 0,
                'qr_code' => 'EVT4-USER3-' . uniqid(),
                'checked_in' => false,
                'checked_in_at' => null,
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ],
            [
                'event_id' => 4,
                'user_id' => 4, // Ana Lucía - confirmada
                'status' => 'confirmed',
                'guest_count' => 0,
                'qr_code' => 'EVT4-USER4-' . uniqid(),
                'checked_in' => false,
                'checked_in_at' => null,
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ]
        ];

        foreach ($attendances as $attendance) {
            DB::table('event_attendance')->insert($attendance);
        }

        $this->command->info('✅ EventAttendanceSeeder ejecutado correctamente. 12 asistencias a eventos creadas.');
    }
}