<?php

use App\Models\Course;

it('adds given courses', function () {
    // Arrange
    $this->assertDatabaseCount(Course::class, 0);

    // Act & Assert
    $this->artisan('db:seed --class=AddGivenCoursesSeeder');

    $this->assertDatabaseCount(Course::class, 3);
    $this->assertDatabaseHas(Course::class, ['title' => 'Laravel For Beginners']);
    $this->assertDatabaseHas(Course::class, ['title' => 'Advanced Laravel']);
    $this->assertDatabaseHas(Course::class, ['title' => 'TDD The Laravel Way']);
});


it('adds given courses only once', function () {
    // Arrange
    $this->assertDatabaseCount(Course::class, 0);

    $this->artisan('db:seed --class=AddGivenCoursesSeeder');
    $this->artisan('db:seed --class=AddGivenCoursesSeeder');
    // Act & Assert

    $this->assertDatabaseCount(Course::class, 3);

});

it('adds given videos', function () {
    // Arrange

    // Act & Assert
});

it('adds given videos only  once', function () {
    // Arrange

    // Act & Assert
});
