<?php

use App\Models\Course;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('does not find unreleased courses', function () {
    // Arrange
    $unreleasedCourse = Course::factory()->create(['released_at' => null]);
    // Act & Assert
    get(route('pages.course.details', $unreleasedCourse))
        ->assertNotFound();
});

it('shows course details', function () {
    // Arrange
    $releasedCourse = Course::factory()->create();
    // Act & Assert
    get(route('pages.course.details', $releasedCourse))
        ->assertOk()
        ->assertSeeText([
            $releasedCourse->title,
            $releasedCourse->description,
            $releasedCourse->tagline,
            ...$releasedCourse->learnings,
        ])
        ->assertSee(asset("images/$releasedCourse->image_name"));
});

it('shows course video count', function () {
    // Arrange
    $releasedCourse = Course::factory()
        ->has(Video::factory(3))
        ->create();
    // Act & Assert
    get(route('pages.course.details', $releasedCourse))
        ->assertOk()
        ->assertSeeText('3 Videos');
});
