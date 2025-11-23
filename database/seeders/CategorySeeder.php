<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // CATEGORÍAS PRINCIPALES
            [
                'name' => 'Artes Visuales',
                'description' => 'Pintura, escultura, fotografía y artes plásticas de artistas popayanejos',
                'icon' => '🎨',
                'color' => '#FF6B6B',
                'slug' => 'artes-visuales',
                'is_active' => true,
                'sort_order' => 1,
                'parent_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Artes Escénicas',
                'description' => 'Teatro, danza, música folclórica y performances culturales',
                'icon' => '🎭',
                'color' => '#4ECDC4',
                'slug' => 'artes-escenicas',
                'is_active' => true,
                'sort_order' => 2,
                'parent_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Artesanías',
                'description' => 'Artesanías típicas del Cauca y técnicas tradicionales',
                'icon' => '🧵',
                'color' => '#45B7D1',
                'slug' => 'artesanias',
                'is_active' => true,
                'sort_order' => 3,
                'parent_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Patrimonio Cultural',
                'description' => 'Historia, arquitectura y patrimonio cultural de Popayán',
                'icon' => '🏛️',
                'color' => '#96CEB4',
                'slug' => 'patrimonio-cultural',
                'is_active' => true,
                'sort_order' => 4,
                'parent_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gastronomía',
                'description' => 'Comida típica caucana y tradiciones culinarias',
                'icon' => '🍲',
                'color' => '#FECA57',
                'slug' => 'gastronomia',
                'is_active' => true,
                'sort_order' => 5,
                'parent_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Literatura',
                'description' => 'Escritores, poetas y literatura popayaneja',
                'icon' => '📚',
                'color' => '#FF9FF3',
                'slug' => 'literatura',
                'is_active' => true,
                'sort_order' => 6,
                'parent_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Festividades',
                'description' => 'Carnavales, festivales y celebraciones tradicionales',
                'icon' => '🎉',
                'color' => '#54A0FF',
                'slug' => 'festividades',
                'is_active' => true,
                'sort_order' => 7,
                'parent_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert($category);
        }

        $this->command->info('✅ CategorySeeder ejecutado correctamente. 7 categorías principales creadas.');
    }
}