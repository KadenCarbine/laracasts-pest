<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/** @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video> */
class VideoFactory extends Factory
{
    public function definition(): array
    {
        return [

            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
