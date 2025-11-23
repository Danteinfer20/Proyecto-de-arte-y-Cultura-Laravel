<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comments = [
            // COMENTARIOS EN ARTÍCULO DE SEMANA SANTA (Post ID 1)
            [
                'post_id' => 1, // Semana Santa
                'user_id' => 5, // Laura Sofía Gutiérrez (ID REAL: 5)
                'parent_id' => null,
                'content' => '¡Qué artículo tan completo! Siempre me ha fascinado la Semana Santa en Popayán. ¿Sabían que mi abuela participaba en la elaboración de las alfombras florales?',
                'like_count' => 5,
                'is_edited' => false,
                'status' => 'visible',
                'created_at' => Carbon::now()->subDays(12),
                'updated_at' => Carbon::now()->subDays(12),
            ],
            [
                'post_id' => 1, // Semana Santa
                'user_id' => 6, // David Andrés Pérez (ID REAL: 6)
                'parent_id' => null,
                'content' => 'Como estudiante de arquitectura, valoro mucho cómo este artículo destaca el valor patrimonial de nuestras tradiciones. ¿Habrá algún tour guiado este año?',
                'like_count' => 3,
                'is_edited' => false,
                'status' => 'visible',
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(10),
            ],
            [
                'post_id' => 1, // Semana Santa
                'user_id' => 1, // Administrador Cultural (ID REAL: 1)
                'parent_id' => 2, // Respuesta a David
                'content' => 'Hola David, sí habrá tours guiados. Estaremos publicando la información en los próximos días. ¡Gracias por tu interés!',
                'like_count' => 2,
                'is_edited' => false,
                'status' => 'visible',
                'created_at' => Carbon::now()->subDays(9),
                'updated_at' => Carbon::now()->subDays(9),
            ],

            // COMENTARIOS EN TÉCNICAS DE TEJIDO (Post ID 4)
            [
                'post_id' => 4, // Técnicas de Tejido
                'user_id' => 5, // Laura Sofía Gutiérrez (ID REAL: 5)
                'parent_id' => null,
                'content' => 'Me encantaría aprender estas técnicas. ¿Ofrecen talleres para principiantes? Me interesa especialmente el tejido de guanga.',
                'like_count' => 4,
                'is_edited' => false,
                'status' => 'visible',
                'created_at' => Carbon::now()->subDays(8),
                'updated_at' => Carbon::now()->subDays(8),
            ],
            [
                'post_id' => 4, // Técnicas de Tejido
                'user_id' => 2, // María Fernanda López (ID REAL: 2)
                'parent_id' => 4, // Respuesta a Laura
                'content' => 'Hola Laura, sí ofrezco talleres los sábados en el Centro Cultural de Bellas Artes. Puedes contactarme por interno para más información. ¡Sería un gusto enseñarte!',
                'like_count' => 6,
                'is_edited' => false,
                'status' => 'visible',
                'created_at' => Carbon::now()->subDays(7),
                'updated_at' => Carbon::now()->subDays(7),
            ],

            // COMENTARIOS EN PERFIL DE CARLOS MENDOZA (Post ID 2)
            [
                'post_id' => 2, // Carlos Mendoza
                'user_id' => 6, // David Andrés Pérez (ID REAL: 6)
                'parent_id' => null,
                'content' => 'Admiro mucho la obra de Carlos. Tuve la oportunidad de ver su exposición el año pasado y las texturas que logra con las técnicas mixtas son increíbles.',
                'like_count' => 7,
                'is_edited' => false,
                'status' => 'visible',
                'created_at' => Carbon::now()->subDays(6),
                'updated_at' => Carbon::now()->subDays(6),
            ],
            [
                'post_id' => 2, // Carlos Mendoza
                'user_id' => 3, // Carlos Arturo Mendoza (ID REAL: 3)
                'parent_id' => 6, // Respuesta a David
                'content' => 'Muchas gracias David por tu comentario. Me alegra que hayas disfrutado la exposición. Estoy preparando nueva obra inspirada en el Nevado del Puracé.',
                'like_count' => 8,
                'is_edited' => false,
                'status' => 'visible',
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ],

            // COMENTARIOS EN FESTIVAL DE ARTE JOVEN (Post ID 3)
            [
                'post_id' => 3, // Festival Arte Joven
                'user_id' => 5, // Laura Sofía Gutiérrez (ID REAL: 5)
                'parent_id' => null,
                'content' => '¡Excelente iniciativa! Tengo 25 años y me dedico a la fotografía. ¿Puedo participar con una serie sobre los mercados campesinos del Cauca?',
                'like_count' => 3,
                'is_edited' => false,
                'status' => 'visible',
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subDays(4),
            ],
            [
                'post_id' => 3, // Festival Arte Joven
                'user_id' => 4, // Ana Lucía Torres (ID REAL: 4)
                'parent_id' => 8, // Respuesta a Laura
                'content' => 'Hola Laura, claro que sí. Las series fotográficas son bienvenidas. Te invito a revisar las bases en nuestro sitio web y enviar tu propuesta. ¡Éxitos!',
                'like_count' => 2,
                'is_edited' => false,
                'status' => 'visible',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'post_id' => 3, // Festival Arte Joven
                'user_id' => 6, // David Andrés Pérez (ID REAL: 6)
                'parent_id' => null,
                'content' => 'Me parece fantástico que apoyen a los jóvenes artistas. ¿Hay alguna categoría específica para instalaciones o arte conceptual?',
                'like_count' => 1,
                'is_edited' => false,
                'status' => 'visible',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ]
        ];

        foreach ($comments as $comment) {
            DB::table('comments')->insert($comment);
        }

        $this->command->info('✅ CommentSeeder ejecutado correctamente. 10 comentarios creados con interacciones sociales.');
    }
}