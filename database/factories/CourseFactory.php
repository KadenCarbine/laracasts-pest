<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/** @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course> */
class CourseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'slug' => $this->faker->unique()->slug(),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'tagline' => $this->faker->sentence(),
            'image_name' => 'image.jpg',
            'learnings' => ['Learn A', 'Learn B', 'Learn C', 'Learn D'],
            'released_at' => Carbon::yesterday(),
        ];
    }
}
