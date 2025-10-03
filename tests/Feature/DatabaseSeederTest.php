<?php

use App\Models\Course;
use App\Models\User;
use App\Models\Video;

it('adds given courses', function () {
    // Arrange
    $this->assertDatabaseCount(Course::class, 0);

    // Act & Assert
    $this->artisan('db:seed');

    $this->assertDatabaseCount(Course::class, 3);
    $this->assertDatabaseHas(Course::class, ['title' => 'Laravel For Beginners']);
    $this->assertDatabaseHas(Course::class, ['title' => 'Advanced Laravel']);
    $this->assertDatabaseHas(Course::class, ['title' => 'TDD The Laravel Way']);
});


it('adds given courses only once', function () {
    // Arrange
    $this->assertDatabaseCount(Course::class, 0);

    $this->artisan('db:seed');
    $this->artisan('db:seed');
    // Act & Assert

    $this->assertDatabaseCount(Course::class, 3);
});

it('adds given videos', function () {
    // Arrange
    $this->assertDatabaseCount(Video::class, 0);

    // Act & Assert
    $this->artisan('db:seed');

    $this->assertDatabaseCount(Video::class, 8);
    $laravelForBeginnersCourse = Course::where('title', 'Laravel For Beginners')->firstOrFail();
    $advancedLaravelCourse = Course::where('title', 'Advanced Laravel')->firstOrFail();
    $tddTheLaravelWayCourse = Course::where('title', 'TDD The Laravel Way')->firstOrFail();

    expect($laravelForBeginnersCourse->videos)->toHaveCount(3)
        ->and($advancedLaravelCourse->videos)->toHaveCount(3)
        ->and($tddTheLaravelWayCourse->videos)->toHaveCount(2);
});

it('adds given videos only once', function () {
    // Arrange
    $this->assertDatabaseCount(Video::class, 0);

    $this->artisan('db:seed');
    $this->artisan('db:seed');
    // Act & Assert

    $this->assertDatabaseCount(Video::class, 8);
});

it('adds local test user', function () {
    // Arrange
    App::partialMock()->shouldReceive('environment')->andReturn('local');
    $this->assertDatabaseCount(User::class, 0);
    // Act & Assert
    $this->artisan('db:seed');
    $this->assertDatabaseCount(User::class, 1);
});
it('only adds the test user once', function () {
    // Arrange
    App::partialMock()->shouldReceive('environment')->andReturn('local');
    $this->assertDatabaseCount(User::class, 0);
    // Act & Assert
    $this->artisan('db:seed');
    $this->artisan('db:seed');
    $this->artisan('db:seed');
    $this->assertDatabaseCount(User::class, 1);
});

it('does not add test user for production', function () {
    // Arrange
    App::partialMock()->shouldReceive('environment')->andReturn('production');
    $this->assertDatabaseCount(User::class, 0);
    // Act & Assert
    $this->artisan('db:seed');
    $this->assertDatabaseCount(User::class, 0);
});
