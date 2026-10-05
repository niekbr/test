<?php

namespace Tests\Feature;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategorySeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_categories_when_none_exist(): void
    {
        $this->seed(CategorySeeder::class);

        $this->assertSame(5, Category::query()->count());
    }

    public function test_it_does_not_create_categories_when_some_already_exist(): void
    {
        Category::query()->create();

        $this->seed(CategorySeeder::class);
        $this->seed(CategorySeeder::class);

        $this->assertSame(1, Category::query()->count());
    }
}
