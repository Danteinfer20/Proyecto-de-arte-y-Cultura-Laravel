<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AIRecoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $aiRecommendations = [
            // RECOMENDACIONES PARA LAURA SOFÍA (ID 5) - Interés en artesanías
            [
                'user_id' => 5,
                'recommended_post_id' => 4, // Técnicas de Tejido
                'recommendation_type' => 'educational',
                'confidence_score' => 0.87,
                'reason' => 'Basado en tu interés en artesanías y talleres prácticos',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'user_id' => 5,
                'recommended_post_id' => 2, // Carlos Mendoza - Arte
                'recommendation_type' => 'cultural',
                'confidence_score' => 0.72,
                'reason' => 'Artistas locales que podrían interesarte',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],

            // RECOMENDACIONES PARA DAVID ANDRÉS (ID 6) - Interés en arquitectura
            [
                'user_id' => 6,
                'recommended_post_id' => 1, // Semana Santa - Patrimonio
                'recommendation_type' => 'cultural',
                'confidence_score' => 0.91,
                'reason' => 'Patrimonio arquitectónico y cultural de Popayán',
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'user_id' => 6,
                'recommended_post_id' => 3, // Festival Arte Joven
                'recommendation_type' => 'event',
                'confidence_score' => 0.68,
                'reason' => 'Eventos culturales para jóvenes artistas',
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ],

            // RECOMENDACIONES PARA CARLOS MENDOZA (ID 3) - Artista
            [
                'user_id' => 3,
                'recommended_post_id' => 1, // Semana Santa
                'recommendation_type' => 'cultural',
                'confidence_score' => 0.79,
                'reason' => 'Inspiración para nuevas obras sobre tradiciones locales',
                'created_at' => Carbon::now()->subDays(7),
                'updated_at' => Carbon::now()->subDays(7),
            ],

            // RECOMENDACIONES PARA MARÍA FERNANDA (ID 2) - Artesana
            [
                'user_id' => 2,
                'recommended_post_id' => 3, // Festival Arte Joven
                'recommendation_type' => 'event',
                'confidence_score' => 0.85,
                'reason' => 'Oportunidades para exhibir tus artesanías',
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subDays(4),
            ],

            // RECOMENDACIONES PARA ANA LUCÍA (ID 4) - Gestora cultural
            [
                'user_id' => 4,
                'recommended_post_id' => 2, // Carlos Mendoza
                'recommendation_type' => 'cultural',
                'confidence_score' => 0.88,
                'reason' => 'Artistas destacados para futuras colaboraciones',
                'created_at' => Carbon::now()->subDays(6),
                'updated_at' => Carbon::now()->subDays(6),
            ],

            // RECOMENDACIONES PARA ADMINISTRADOR (ID 1)
            [
                'user_id' => 1,
                'recommended_post_id' => 4, // Técnicas de Tejido
                'recommendation_type' => 'educational',
                'confidence_score' => 0.93,
                'reason' => 'Contenido educativo popular entre los usuarios',
                'created_at' => Carbon::now()->subDays(8),
                'updated_at' => Carbon::now()->subDays(8),
            ]
        ];

        foreach ($aiRecommendations as $recommendation) {
            DB::table('ai_recommendations')->insert($recommendation);
        }

        $this->command->info('✅ AIRecoSeeder ejecutado correctamente. 8 recomendaciones de IA creadas.');
    }
}