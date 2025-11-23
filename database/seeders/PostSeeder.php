<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            // ARTÍCULO SOBRE PATRIMONIO
            [
                'user_id' => 1, // Administrador Cultural (ID REAL: 1)
                'category_id' => 4, // Patrimonio Cultural
                'content_type_id' => 1, // artículo
                'title' => 'La Semana Santa en Popayán: Patrimonio Cultural Inmaterial',
                'slug' => 'semana-santa-popayan-patrimonio-cultural',
                'content' => 'La Semana Santa en Popayán es una de las manifestaciones religiosas y culturales más importantes de Colombia. Declarada Patrimonio Cultural Inmaterial de la Humanidad por la UNESCO en 2009, esta tradición centenaria combina fe, arte y cultura en una experiencia única que atrae a miles de visitantes cada año.

## Historia y Orígenes
Las procesiones de Semana Santa en Popayán se remontan al siglo XVI, cuando los colonizadores españoles introdujeron estas tradiciones religiosas. Con el tiempo, la ciudad blanca ha desarrollado su propio estilo característico.

## Elementos Destacados
- **Procesiones nocturnas**: Con un ambiente de recogimiento y devoción
- **Esculturas religiosas**: Obras de arte colonial de incalculable valor
- **Música sacra**: Interpretada por bandas locales
- **Alfombras florales**: Elaboradas por la comunidad en las calles

## Significado Cultural
Más allá del aspecto religioso, la Semana Santa representa la identidad payanesa y la conservación de tradiciones ancestrales que se transmiten de generación en generación.',
                'excerpt' => 'Explora la riqueza cultural y religiosa de la Semana Santa en Popayán, declarada Patrimonio de la Humanidad por la UNESCO.',
                'featured_image' => null,
                'status' => 'published',
                'is_featured' => true,
                'allow_comments' => true,
                'view_count' => 245,
                'share_count' => 34,
                'published_at' => Carbon::now()->subDays(15),
                'created_at' => Carbon::now()->subDays(20),
                'updated_at' => Carbon::now()->subDays(5),
            ],

            // PERFIL DE ARTISTA
            [
                'user_id' => 3, // Carlos Arturo Mendoza (ID REAL: 3)
                'category_id' => 1, // Artes Visuales
                'content_type_id' => 5, // perfil_artista
                'title' => 'Carlos Mendoza: El Pintor de los Paisajes Caucanos',
                'slug' => 'carlos-mendoza-pintor-paisajes-caucanos',
                'content' => 'Carlos Arturo Mendoza es uno de los pintores más reconocidos de la región caucana, con una trayectoria de más de 15 años dedicados al arte.

## Trayectoria Artística
Nacido en Popayán en 1982, Carlos descubió su pasión por la pintura desde muy joven. Estudió en la Escuela de Bellas Artes de la Universidad del Cauca y ha participado en más de 20 exposiciones colectivas y 5 individuales.

## Estilo y Técnica
Su obra se caracteriza por:
- **Paisajismo realista**: Captura la esencia de los paisajes del Cauca
- **Técnica mixta**: Combina óleo, acrílico y materiales locales
- **Colores vibrantes**: Refleja la riqueza cromática de la región
- **Temas sociales**: Aborda problemáticas rurales y culturales

## Obras Destacadas
- "Atardecer en el Puente del Humilladero"
- "Mercado Campesino de Silvia" 
- "Nevado del Puracé en Invierno"
- "Procesión Nocturna en Popayán"

## Exposiciones Recientes
- Galería de Arte Contemporáneo (2024)
- Museo de Arte Moderno de Bogotá (2023)
- Bienal de Arte Latinoamericano (2022)',
                'excerpt' => 'Conoce la vida y obra de Carlos Mendoza, pintor popayanejo cuya obra captura la belleza y esencia del Cauca.',
                'featured_image' => null,
                'status' => 'published',
                'is_featured' => false,
                'allow_comments' => true,
                'view_count' => 178,
                'share_count' => 22,
                'published_at' => Carbon::now()->subDays(8),
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(2),
            ],

            // NOTICIA CULTURAL
            [
                'user_id' => 4, // Ana Lucía Torres (ID REAL: 4)
                'category_id' => 2, // Artes Escénicas
                'content_type_id' => 6, // noticia
                'title' => 'Festival de Arte Joven 2024: Convocatoria Abierta',
                'slug' => 'festival-arte-joven-2024-convocatoria',
                'content' => 'El Festival de Arte Joven de Popayán anuncia su convocatoria para la edición 2024, dirigida a artistas emergentes entre 18 y 30 años.

## Categorías de Participación
- **Artes Visuales**: Pintura, escultura, fotografía
- **Artes Escénicas**: Teatro, danza, performance
- **Música**: Solistas y agrupaciones
- **Literatura**: Poesía y narrativa breve

## Fechas Importantes
- **Inscripciones**: Hasta el 15 de diciembre 2024
- **Selección**: 20 de diciembre 2024
- **Presentaciones**: 15-20 de enero 2025

## Requisitos
- Ser residente del departamento del Cauca
- Tener entre 18 y 30 años
- Presentar proyecto artístico inédito
- Llenar formulario de inscripción en línea

## Premios y Reconocimientos
- Exposición colectiva en galerías locales
- Presentación en espacios culturales
- Certificación de participación
- Oportunidades de formación',
                'excerpt' => 'Abierta la convocatoria para el Festival de Arte Joven 2024. Inscripciones hasta el 15 de diciembre.',
                'featured_image' => null,
                'status' => 'published',
                'is_featured' => true,
                'allow_comments' => true,
                'view_count' => 312,
                'share_count' => 45,
                'published_at' => Carbon::now()->subDays(3),
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(1),
            ],

            // CONTENIDO EDUCATIVO
            [
                'user_id' => 2, // María Fernanda López (ID REAL: 2)
                'category_id' => 3, // Artesanías
                'content_type_id' => 4, // educativo
                'title' => 'Técnicas de Tejido Tradicional del Cauca',
                'slug' => 'tecnicas-tejido-tradicional-cauca',
                'content' => 'Las técnicas de tejido tradicional son parte fundamental del patrimonio cultural inmaterial del Cauca. Esta guía te introduce en las principales técnicas.

## Materiales Tradicionales
- **Lana de oveja**: Teñida con colorantes naturales
- **Fique**: Fibra natural extraída del agave
- **Bombilla**: Para tejidos más finos y delicados
- **Tintas naturales**: Achiote, nogal, cúrcuma

## Técnicas Principales

### Tejido de Guanga
Técnica ancestral utilizada para crear mochilas y bolsos:
1. Preparación del material
2. Montaje en el telar
3. Tejido circular
4. Acabados y decoración

### Tejido en Telar de Cintura
Utilizado para ruanas y prendas de vestir:
- Armado del telar
- Uso de lanzadera
- Patrones geométricos
- Simbología indígena

### Bordado a Mano
Decoración de prendas con motivos culturales:
- Punto de cruz
- Punto cadena
- Aplicación de chaquiras
- Representación de la naturaleza

## Significado Cultural
Cada patrón y color tiene un significado específico relacionado con la cosmovisión indígena y la conexión con la naturaleza.',
                'excerpt' => 'Aprende sobre las técnicas ancestrales de tejido del Cauca y su importancia en la preservación cultural.',
                'featured_image' => null,
                'status' => 'published',
                'is_featured' => false,
                'allow_comments' => true,
                'view_count' => 89,
                'share_count' => 15,
                'published_at' => Carbon::now()->subDays(12),
                'created_at' => Carbon::now()->subDays(15),
                'updated_at' => Carbon::now()->subDays(10),
            ]
        ];

        foreach ($posts as $post) {
            DB::table('posts')->insert($post);
        }

        $this->command->info('✅ PostSeeder ejecutado correctamente. 4 posts culturales creados.');
    }
}