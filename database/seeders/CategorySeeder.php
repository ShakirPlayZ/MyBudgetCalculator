<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Gehalt', 'type' => 'income'],
            ['name' => 'Kindergeld', 'type' => 'income'],
            ['name' => 'Miete', 'type' => 'expense'],
            ['name' => 'Lebensmittel', 'type' => 'expense'],
            ['name' => 'Versicherungen', 'type' => 'expense'],
            ['name' => 'Freizeit', 'type' => 'expense'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
