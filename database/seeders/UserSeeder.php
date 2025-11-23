<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            // ADMINISTRADOR
            [
                'name' => 'Administrador Cultural',
                'username' => 'admincultural',
                'email' => 'admin@culturappopayan.com',
                'password' => Hash::make('password123'),
                'user_type' => 'admin',
                'birth_date' => '1985-06-15',
                'gender' => 'masculino',
                'phone' => '+573001234567',
                'city' => 'Popayán',
                'neighborhood' => 'Centro Histórico',
                'bio' => 'Administrador del sistema de arte y cultura de Popayán.',
                'profile_picture' => null,
                'cover_picture' => null,
                'website' => 'https://culturappopayan.com',
                'social_media' => json_encode(['facebook' => 'culturappopayan']),
                'email_verified_at' => now(),
                'last_login_at' => now(),
                'status' => 'active',
                'is_verified' => true,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ARTISTAS
            [
                'name' => 'María Fernanda López',
                'username' => 'maria_artesana',
                'email' => 'maria.artesana@email.com',
                'password' => Hash::make('password123'),
                'user_type' => 'artist',
                'birth_date' => '1990-03-22',
                'gender' => 'femenino',
                'phone' => '+573002345678',
                'city' => 'Popayán',
                'neighborhood' => 'Bolívar',
                'bio' => 'Artesana especializada en tejidos tradicionales del Cauca.',
                'profile_picture' => null,
                'cover_picture' => null,
                'website' => null,
                'social_media' => json_encode(['instagram' => 'maria_artesana_cauca']),
                'email_verified_at' => now(),
                'last_login_at' => now(),
                'status' => 'active',
                'is_verified' => true,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Carlos Arturo Mendoza',
                'username' => 'carlos_pintor',
                'email' => 'carlos.mendoza@email.com',
                'password' => Hash::make('password123'),
                'user_type' => 'artist',
                'birth_date' => '1982-11-08',
                'gender' => 'masculino',
                'phone' => '+573003456789',
                'city' => 'Popayán',
                'neighborhood' => 'Alto Menga',
                'bio' => 'Pintor popayanejo con más de 15 años de experiencia.',
                'profile_picture' => null,
                'cover_picture' => null,
                'website' => 'https://carlosmendozarte.com',
                'social_media' => json_encode(['instagram' => 'carlos_mendoza_arte']),
                'email_verified_at' => now(),
                'last_login_at' => now(),
                'status' => 'active',
                'is_verified' => true,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // GESTOR CULTURAL
            [
                'name' => 'Ana Lucía Torres',
                'username' => 'ana_gestora',
                'email' => 'ana.torres@email.com',
                'password' => Hash::make('password123'),
                'user_type' => 'cultural_manager',
                'birth_date' => '1988-07-30',
                'gender' => 'femenino',
                'phone' => '+573004567890',
                'city' => 'Popayán',
                'neighborhood' => 'La Esmeralda',
                'bio' => 'Gestora cultural con especialización en proyectos artísticos.',
                'profile_picture' => null,
                'cover_picture' => null,
                'website' => null,
                'social_media' => json_encode(['instagram' => 'ana_gestora_cultural']),
                'email_verified_at' => now(),
                'last_login_at' => now(),
                'status' => 'active',
                'is_verified' => true,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // VISITANTES
            [
                'name' => 'Laura Sofía Gutiérrez',
                'username' => 'laura_visitante',
                'email' => 'laura.gutierrez@email.com',
                'password' => Hash::make('password123'),
                'user_type' => 'visitor',
                'birth_date' => '1995-04-18',
                'gender' => 'femenino',
                'phone' => '+573006789012',
                'city' => 'Popayán',
                'neighborhood' => 'San Fernando',
                'bio' => 'Amante del arte y la cultura popayaneja.',
                'profile_picture' => null,
                'cover_picture' => null,
                'website' => null,
                'social_media' => null,
                'email_verified_at' => now(),
                'last_login_at' => now(),
                'status' => 'active',
                'is_verified' => false,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'David Andrés Pérez',
                'username' => 'david_visitante',
                'email' => 'david.perez@email.com',
                'password' => Hash::make('password123'),
                'user_type' => 'visitor',
                'birth_date' => '1998-09-25',
                'gender' => 'masculino',
                'phone' => '+573007890123',
                'city' => 'Popayán',
                'neighborhood' => 'Villa del Río',
                'bio' => 'Estudiante de arquitectura interesado en el patrimonio cultural.',
                'profile_picture' => null,
                'cover_picture' => null,
                'website' => null,
                'social_media' => null,
                'email_verified_at' => now(),
                'last_login_at' => now(),
                'status' => 'active',
                'is_verified' => false,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }

        $this->command->info('✅ UserSeeder ejecutado correctamente. 6 usuarios creados.');
    }
}