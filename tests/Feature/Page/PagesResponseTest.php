<?php

use App\Models\Course;
use App\Models\User;
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

it('returns a successful response for the dashboard page', function () {
    // Arrange
    $user = User::factory()->create();

    // Act & Assert
    $this->actingAs($user);

    get(route('dashboard'))
        ->assertOk();
});
