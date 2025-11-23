<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            // EXPOSICIÓN DE CARLOS MENDOZA
            [
                'post_id' => 2, // Post: "Carlos Mendoza: El Pintor de los Paisajes Caucanos"
                'location_id' => 5, // Galería de Arte Contemporáneo
                'organizer_id' => 3, // Carlos Arturo Mendoza (ID REAL: 3)
                'start_date' => Carbon::now()->addDays(10)->setHour(10)->setMinute(0),
                'end_date' => Carbon::now()->addDays(45)->setHour(18)->setMinute(0),
                'price' => 0.00,
                'max_capacity' => 80,
                'available_slots' => 80,
                'requires_rsvp' => false,
                'event_type' => 'free',
                'event_status' => 'scheduled',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // FESTIVAL DE ARTE JOVEN - PRESENTACIONES
            [
                'post_id' => 3, // Post: "Festival de Arte Joven 2024: Convocatoria Abierta"
                'location_id' => 3, // Teatro Municipal Guillermo Valencia
                'organizer_id' => 4, // Ana Lucía Torres (ID REAL: 4)
                'start_date' => Carbon::now()->addDays(30)->setHour(19)->setMinute(0),
                'end_date' => Carbon::now()->addDays(35)->setHour(22)->setMinute(0),
                'price' => 15000.00,
                'max_capacity' => 400,
                'available_slots' => 400,
                'requires_rsvp' => true,
                'event_type' => 'paid',
                'event_status' => 'scheduled',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // TALLER DE TEJIDO TRADICIONAL
            [
                'post_id' => 4, // Post: "Técnicas de Tejido Tradicional del Cauca"
                'location_id' => 6, // Centro Cultural de Bellas Artes
                'organizer_id' => 2, // María Fernanda López (ID REAL: 2)
                'start_date' => Carbon::now()->addDays(15)->setHour(14)->setMinute(0),
                'end_date' => Carbon::now()->addDays(15)->setHour(17)->setMinute(0),
                'price' => 25000.00,
                'max_capacity' => 25,
                'available_slots' => 25,
                'requires_rsvp' => true,
                'event_type' => 'paid',
                'event_status' => 'scheduled',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // CHARLA SOBRE PATRIMONIO CULTURAL
            [
                'post_id' => 1, // Post: "La Semana Santa en Popayán: Patrimonio Cultural Inmaterial"
                'location_id' => 7, // Biblioteca Departamental del Cauca
                'organizer_id' => 1, // Administrador Cultural (ID REAL: 1)
                'start_date' => Carbon::now()->addDays(5)->setHour(16)->setMinute(0),
                'end_date' => Carbon::now()->addDays(5)->setHour(18)->setMinute(0),
                'price' => 0.00,
                'max_capacity' => 120,
                'available_slots' => 120,
                'requires_rsvp' => true,
                'event_type' => 'free',
                'event_status' => 'scheduled',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($events as $event) {
            DB::table('events')->insert($event);
        }

        $this->command->info('✅ EventSeeder ejecutado correctamente. 4 eventos culturales creados.');
    }
}