<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            // MUSEOS
            [
                'name' => 'Museo de Arte Religioso',
                'address' => 'Calle 4 #4-56',
                'neighborhood' => 'Centro Histórico',
                'city' => 'Popayán',
                'latitude' => 2.4415,
                'longitude' => -76.6060,
                'location_type' => 'museum',
                'phone' => '+5728240950',
                'opening_hours' => 'Martes a Domingo: 9:00 AM - 5:00 PM',
                'description' => 'Importante museo que alberga una valiosa colección de arte religioso colonial, ubicado en el corazón del centro histórico de Popayán.',
                'photo' => null,
                'website' => 'https://museoartereligiosopopayan.org',
                'capacity' => 150,
                'is_accessible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Casa Museo Mosquera',
                'address' => 'Calle 3 #5-14',
                'neighborhood' => 'Centro Histórico',
                'city' => 'Popayán',
                'latitude' => 2.4421,
                'longitude' => -76.6052,
                'location_type' => 'museum',
                'phone' => '+5728243635',
                'opening_hours' => 'Martes a Sábado: 9:00 AM - 5:00 PM',
                'description' => 'Museo dedicado al General Tomás Cipriano de Mosquera, que conserva mobiliario y objetos de la época republicana.',
                'photo' => null,
                'website' => null,
                'capacity' => 80,
                'is_accessible' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // TEATROS
            [
                'name' => 'Teatro Municipal Guillermo Valencia',
                'address' => 'Carrera 6 #10-41',
                'neighborhood' => 'Centro Histórico',
                'city' => 'Popayán',
                'latitude' => 2.4412,
                'longitude' => -76.6048,
                'location_type' => 'theater',
                'phone' => '+5728242196',
                'opening_hours' => 'Lunes a Viernes: 8:00 AM - 6:00 PM',
                'description' => 'Teatro histórico de Popayán, escenario principal de eventos culturales, obras de teatro y presentaciones artísticas.',
                'photo' => null,
                'website' => null,
                'capacity' => 500,
                'is_accessible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Teatro Cesar Constain Gómez',
                'address' => 'Calle 5 #1-35',
                'neighborhood' => 'Centro',
                'city' => 'Popayán',
                'latitude' => 2.4430,
                'longitude' => -76.6035,
                'location_type' => 'theater',
                'phone' => '+5728234567',
                'opening_hours' => 'Lunes a Sábado: 9:00 AM - 7:00 PM',
                'description' => 'Moderno teatro universitario que alberga presentaciones de danza, teatro experimental y eventos académicos.',
                'photo' => null,
                'website' => null,
                'capacity' => 300,
                'is_accessible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // GALERÍAS
            [
                'name' => 'Galería de Arte Contemporáneo',
                'address' => 'Calle 5 #8-62',
                'neighborhood' => 'Centro Histórico',
                'city' => 'Popayán',
                'latitude' => 2.4408,
                'longitude' => -76.6032,
                'location_type' => 'gallery',
                'phone' => '+5728237890',
                'opening_hours' => 'Miércoles a Domingo: 10:00 AM - 6:00 PM',
                'description' => 'Espacio dedicado a la exposición y promoción de arte contemporáneo de artistas locales y nacionales.',
                'photo' => null,
                'website' => null,
                'capacity' => 100,
                'is_accessible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // CENTROS CULTURALES
            [
                'name' => 'Centro Cultural de Bellas Artes',
                'address' => 'Carrera 8 #7-25',
                'neighborhood' => 'Bolívar',
                'city' => 'Popayán',
                'latitude' => 2.4450,
                'longitude' => -76.6020,
                'location_type' => 'cultural_center',
                'phone' => '+5728245678',
                'opening_hours' => 'Lunes a Viernes: 8:00 AM - 8:00 PM, Sábados: 9:00 AM - 2:00 PM',
                'description' => 'Centro dedicado a la formación y exposición artística, con talleres, cursos y muestras de arte.',
                'photo' => null,
                'website' => null,
                'capacity' => 200,
                'is_accessible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // BIBLIOTECAS
            [
                'name' => 'Biblioteca Departamental del Cauca',
                'address' => 'Calle 5 #4-50',
                'neighborhood' => 'Centro',
                'city' => 'Popayán',
                'latitude' => 2.4425,
                'longitude' => -76.6040,
                'location_type' => 'library',
                'phone' => '+5728241234',
                'opening_hours' => 'Lunes a Viernes: 8:00 AM - 6:00 PM, Sábados: 9:00 AM - 1:00 PM',
                'description' => 'Principal biblioteca del departamento, con extensa colección de literatura y sala de exposiciones.',
                'photo' => null,
                'website' => null,
                'capacity' => 250,
                'is_accessible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // AUDITORIOS
            [
                'name' => 'Auditorio Universidad del Cauca',
                'address' => 'Calle 5 #4-70',
                'neighborhood' => 'Centro',
                'city' => 'Popayán',
                'latitude' => 2.4432,
                'longitude' => -76.6038,
                'location_type' => 'auditorium',
                'phone' => '+5728230987',
                'opening_hours' => 'Lunes a Viernes: 7:00 AM - 9:00 PM',
                'description' => 'Auditorio principal de la Universidad del Cauca para conferencias, simposios y eventos académicos.',
                'photo' => null,
                'website' => null,
                'capacity' => 400,
                'is_accessible' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($locations as $location) {
            DB::table('locations')->insert($location);
        }

        $this->command->info('✅ LocationSeeder ejecutado correctamente. 8 lugares culturales creados.');
    }
}