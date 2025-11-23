<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ContentTypeSeeder::class,
            CategorySeeder::class,
            UserSeeder::class,
            LocationSeeder::class,
            PostSeeder::class,
            EventSeeder::class,
            ProductSeeder::class,
            EducationalContentSeeder::class,
            TagSeeder::class,
            CommentSeeder::class,
            PostTagsSeeder::class,
            ReactionSeeder::class,
            SavedItemSeeder::class, 
             EventAttendanceSeeder::class,
             FollowSeeder::class,
        ]);
    }
}