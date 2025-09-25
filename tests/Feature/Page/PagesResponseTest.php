<?php

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('returns a successful response for the home page', function () {
    get(route('pages.home'))
        ->assertOk();
});

it('returns a successful response for the course detail page', function () {
    // Arrange
    $course = Course::factory()->create();

    // Act &  Assert
    get(route('pages.course.details', $course))
        ->assertOk();
});
