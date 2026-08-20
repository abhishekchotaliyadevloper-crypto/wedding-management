<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GalleryCategoryModel;

class GalleryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galleryCategories = [
            ['name' => 'Wedding Photography','description'=>'Your love story, perfectly told', 'slug' => 'wedding-photography'],
            ['name' => 'Pre-Wedding Photography', 'description' => 'The journey begins', 'slug' => 'pre-wedding-photography'],
            ['name' => 'Maternity & Baby Shoot', 'description' => 'Cherishing every milestone',  'slug' => 'maternity-baby-shoot'],
            ['name' => 'Product Photography','description' => 'Elevate your brand', 'slug' => 'product-photography'],
            ['name' => 'Modeling', 'description' => 'Showcase your best self', 'slug' => 'modeling'],
            ['name' => 'Interior', 'description' => 'Showcase your best self', 'slug' => 'interior'],
        ];

        foreach ($galleryCategories as $category) {
            GalleryCategoryModel::create($category);
        }
    }
}
