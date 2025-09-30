<?php

use App\Models\Course;
use App\Models\User;

use function Pest\Laravel\get;


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

    // Act & Assert
    loginAsUser();

    get(route('pages.dashboard'))
        ->assertOk();
});

it('does not find JetStream registration page', function () {
    // Arrange

    // Act
    get('register')->assertNotFound();
    // Assert
});
