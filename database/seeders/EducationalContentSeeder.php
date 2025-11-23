<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EducationalContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $educationalContents = [
            // CONTENIDO EDUCATIVO PARA TÉCNICAS DE TEJIDO (Post ID 4)
            [
                'post_id' => 4, // Post: "Técnicas de Tejido Tradicional del Cauca"
                'difficulty_level' => 'beginner',
                'estimated_read_time' => 15,
                'learning_objectives' => json_encode([
                    'Identificar los materiales tradicionales del tejido caucano',
                    'Comprender las tres técnicas principales de tejido',
                    'Reconocer el significado cultural de los patrones',
                    'Aprender sobre la preparación de tintes naturales'
                ]),
                'related_topics' => json_encode([
                    'Artesanías indígenas del Cauca',
                    'Técnicas de teñido natural',
                    'Patrimonio cultural inmaterial',
                    'Economía solidaria y artesanal'
                ]),
                'ai_generated' => false,
                'knowledge_area' => 'Artesanías Tradicionales',
                'historical_period' => 'Prehispánico - Contemporáneo',
                'cultural_significance' => 'Las técnicas de tejido representan la continuidad de tradiciones ancestrales y la resistencia cultural de las comunidades indígenas del Cauca. Cada patrón y color transmite conocimientos ancestrales sobre la cosmovisión y la relación con la naturaleza.',
                'created_at' => Carbon::now()->subDays(15),
                'updated_at' => Carbon::now()->subDays(10),
            ],

            // CONTENIDO EDUCATIVO PARA SEMANA SANTA (Post ID 1)
            [
                'post_id' => 1, // Post: "La Semana Santa en Popayán: Patrimonio Cultural Inmaterial"
                'difficulty_level' => 'intermediate',
                'estimated_read_time' => 20,
                'learning_objectives' => json_encode([
                    'Conocer la historia y origen de la Semana Santa en Popayán',
                    'Identificar los elementos culturales y religiosos principales',
                    'Comprender el proceso de declaración como Patrimonio de la Humanidad',
                    'Analizar el impacto cultural y turístico de la celebración'
                ]),
                'related_topics' => json_encode([
                    'Patrimonio cultural inmaterial',
                    'Tradiciones religiosas en Colombia',
                    'Turismo cultural en Popayán',
                    'Conservación del patrimonio'
                ]),
                'ai_generated' => false,
                'knowledge_area' => 'Patrimonio Cultural y Religioso',
                'historical_period' => 'Siglo XVI - Actualidad',
                'cultural_significance' => 'La Semana Santa de Popayán es considerada una de las manifestaciones religiosas más importantes de América Latina. Su valor cultural trasciende lo religioso, representando la identidad payanesa y la preservación de tradiciones centenarias que han sobrevivido a través de generaciones.',
                'created_at' => Carbon::now()->subDays(20),
                'updated_at' => Carbon::now()->subDays(5),
            ],

            // CONTENIDO EDUCATIVO PARA PERFIL DE ARTISTA (Post ID 2)
            [
                'post_id' => 2, // Post: "Carlos Mendoza: El Pintor de los Paisajes Caucanos"
                'difficulty_level' => 'beginner',
                'estimated_read_time' => 12,
                'learning_objectives' => json_encode([
                    'Conocer la trayectoria artística de Carlos Mendoza',
                    'Identificar las características del paisajismo caucano',
                    'Reconocer las técnicas y materiales utilizados',
                    'Comprender el contexto social del arte regional'
                ]),
                'related_topics' => json_encode([
                    'Pintura paisajista en Colombia',
                    'Arte contemporáneo caucano',
                    'Técnicas de pintura al óleo',
                    'Mercado del arte regional'
                ]),
                'ai_generated' => false,
                'knowledge_area' => 'Historia del Arte Regional',
                'historical_period' => 'Siglo XX - XXI',
                'cultural_significance' => 'La obra de Carlos Mendoza documenta visualmente la transformación del paisaje caucano y representa la evolución del arte regional. Su trabajo conecta tradiciones pictóricas con contemporaneidad, sirviendo como testimonio cultural de la región.',
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(2),
            ],

            // CONTENIDO EDUCATIVO ADICIONAL SOBRE GASTRONOMÍA
            [
                'post_id' => 1, // Reutilizando post de Semana Santa para contenido gastronómico relacionado
                'difficulty_level' => 'beginner',
                'estimated_read_time' => 10,
                'learning_objectives' => json_encode([
                    'Identificar los platos típicos de la Semana Santa payanesa',
                    'Conocer el origen de las recetas tradicionales',
                    'Comprender el significado cultural de la comida ritual',
                    'Aprender sobre ingredientes autóctonos utilizados'
                ]),
                'related_topics' => json_encode([
                    'Gastronomía tradicional caucana',
                    'Comida ritual y ceremonial',
                    'Ingredientes autóctonos colombianos',
                    'Turismo gastronómico'
                ]),
                'ai_generated' => true,
                'knowledge_area' => 'Gastronomía Tradicional',
                'historical_period' => 'Colonial - Contemporáneo',
                'cultural_significance' => 'La gastronomía de Semana Santa en Popayán fusiona ingredientes prehispánicos con técnicas coloniales, creando una tradición culinaria única que refleja el sincretismo cultural de la región.',
                'created_at' => Carbon::now()->subDays(8),
                'updated_at' => Carbon::now()->subDays(1),
            ]
        ];

        foreach ($educationalContents as $content) {
            DB::table('educational_content')->insert($content);
        }

        $this->command->info('✅ EducationalContentSeeder ejecutado correctamente. 4 contenidos educativos creados.');
    }
}
