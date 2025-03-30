<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = $this->faker->unique()->words(2, true);
        $slug = Str::slug($name);

        while (Store::where('slug', $slug)->exists()) {
            $slug = Str::slug($name) . '-' . Str::random(5);
        }

        return [
            'name' => $name,
            'slug' => $slug,
            'description' => $this->faker->sentence(13),
            'logo_image' => $this->faker->imageUrl(300, 300),
            'cover_image' => $this->faker->imageUrl(800, 600)
        ];
    }
}
