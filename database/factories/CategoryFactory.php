<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = $this->faker->words(2, true);
        $slug = Str::slug($name);

        while (Category::where('slug', $slug)->exists()) {
            $slug = Str::slug($name) . '-' . Str::random(5);
        }


        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(13),
            'image' => $this->faker->imageUrl
        ];
    }
}
