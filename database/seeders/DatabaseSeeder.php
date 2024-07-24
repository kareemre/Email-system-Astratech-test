<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Email;
use App\Models\Keyword;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $keywords = Keyword::factory()->count(10)->create();

        $categories = Category::factory()
                               ->count(10)
                               ->hasAttached($keywords)
                               ->create();

        $emails = Email::factory()
                        ->count(10)
                        ->hasAttached($categories)
                        ->create();
    }
}
