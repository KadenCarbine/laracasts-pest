<?php

use App\Models\Course;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('shows course details', function () {
    // Arrange
    $course = Course::factory()->create([
        'tagline' => 'Course Tagline',
        'image' => 'image.png',
        'learnings' => [
            'Learn Laravel Routes',
            'Learn Laravel Views',
            'Learn Laravel Commands',
        ],
    ]);
    // Act & Assert
    get(route('course.details', $course))
        ->assertOk()
        ->assertSeeText([
            $course->title,
            $course->description,
            'Course Tagline',
            'Learn Laravel Routes',
            'Learn Laravel Views',
            'Learn Laravel Commands',
        ])
        ->assertSee('image.png');
});

it('shows course video count', function () {
    // Arrange
    $course = Course::factory()->create();
    Video::factory(3)->create(['course_id' => $course->id]);
    // Act & Assert
    get(route('course.details', $course))
        ->assertOk()
        ->assertSeeText('3 Videos');
});
