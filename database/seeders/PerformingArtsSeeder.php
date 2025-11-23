<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PerformingArtsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $performingArts = [
            // EVENTO 2: Festival Arte Joven - Presentaciones escénicas
            [
                'event_id' => 2, // Festival Arte Joven
                'art_type' => 'theater',
                'duration_minutes' => 45,
                'artistic_director' => 'Laura Martínez',
                'company' => 'Colectivo Teatral Joven',
                'genre' => 'Drama contemporáneo',
                'target_audience' => 'Juvenil',
                'technical_requirements' => 'Sistema de sonido, iluminación básica, vestuario',
                'cast_members' => json_encode([
                    ['name' => 'Laura Martínez', 'role' => 'Directora y actriz principal'],
                    ['name' => 'Carlos Ramírez', 'role' => 'Actor de reparto'],
                    ['name' => 'Ana Gómez', 'role' => 'Actriz secundaria']
                ]),
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(10),
            ],
            [
                'event_id' => 2, // Festival Arte Joven
                'art_type' => 'dance',
                'duration_minutes' => 30,
                'artistic_director' => 'Miguel Ángel Torres',
                'company' => 'Grupo de Danza Urbana Cauca',
                'genre' => 'Hip-hop fusion',
                'target_audience' => 'General',
                'technical_requirements' => 'Piso de danza, equipo de audio, luces dinámicas',
                'cast_members' => json_encode([
                    ['name' => 'Miguel Ángel Torres', 'role' => 'Coreógrafo y bailarín'],
                    ['name' => 'Sofia Hernández', 'role' => 'Bailarina principal'],
                    ['name' => 'David López', 'role' => 'Bailarín'],
                    ['name' => 'Camila Rojas', 'role' => 'Bailarina']
                ]),
                'created_at' => Carbon::now()->subDays(8),
                'updated_at' => Carbon::now()->subDays(8),
            ],

            // EVENTO 3: Taller de Tejido - Performance cultural
            [
                'event_id' => 3, // Taller de Tejido
                'art_type' => 'performance',
                'duration_minutes' => 60,
                'artistic_director' => 'María Fernanda López',
                'company' => 'Colectivo de Artesanas del Cauca',
                'genre' => 'Performance cultural',
                'target_audience' => 'Adultos',
                'technical_requirements' => 'Espacio abierto, sillas para participantes, materiales de tejido',
                'cast_members' => json_encode([
                    ['name' => 'María Fernanda López', 'role' => 'Directora artística y maestra tejedora'],
                    ['name' => 'Rosa Guzmán', 'role' => 'Tejedora experta'],
                    ['name' => 'Carmen Díaz', 'role' => 'Asistente de taller']
                ]),
                'created_at' => Carbon::now()->subDays(15),
                'updated_at' => Carbon::now()->subDays(15),
            ],

            // EVENTO 4: Charla Semana Santa - Performance cultural
            [
                'event_id' => 4, // Charla Semana Santa
                'art_type' => 'performance', // CORREGIDO: era 'music'
                'duration_minutes' => 25,
                'artistic_director' => 'Padre Javier Morales',
                'company' => 'Coro Parroquial San Francisco',
                'genre' => 'Música sacra tradicional',
                'target_audience' => 'General',
                'technical_requirements' => 'Sistema de audio, partituras, atriles',
                'cast_members' => json_encode([
                    ['name' => 'Padre Javier Morales', 'role' => 'Director del coro'],
                    ['name' => 'María González', 'role' => 'Soprano'],
                    ['name' => 'Juan Pérez', 'role' => 'Tenor'],
                    ['name' => 'Ana Rodríguez', 'role' => 'Contralto'],
                    ['name' => 'Carlos Silva', 'role' => 'Bajo']
                ]),
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ]
        ];

        foreach ($performingArts as $art) {
            DB::table('performing_arts')->insert($art);
        }

        $this->command->info('✅ PerformingArtsSeeder ejecutado correctamente. 4 artes escénicas creadas.');
    }
}