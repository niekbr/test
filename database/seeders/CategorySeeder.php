<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Seed categories, but only when none exist yet.
     */
    public function run(): void
    {
        if (Category::query()->count() >= 10) {
            return;
        }

        foreach (range(1, 10) as $ignored) {
            Category::query()->create();
        }
    }
}
