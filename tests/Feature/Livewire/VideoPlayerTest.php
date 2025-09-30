<?php

use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\Video;

it('shows details for a given video', function () {
    // Arrange
    $course = Course::factory()
        ->has(Video::factory())
        ->create();

    // Act & Assert
    $firstVideo = $course->videos->first();
    Livewire::test(VideoPlayer::class, ['video' => $firstVideo])
        ->assertSeeText([
            'title' => $firstVideo->title,
            'description' => $firstVideo->description,
            'duration_in_minutes' => "$firstVideo->duration_in_minutes minutes",
        ]);
});

it('shows given video', function () {
    // Arrange
    $course = Course::factory()
        ->has(Video::factory())
        ->create();
    // Act & Assert
    $firstVideo = $course->videos->first();
    Livewire::test(VideoPlayer::class, ['video' => $firstVideo])
        ->assertSeeHtml('<iframe src="https://player.vimeo.com/video/' . $firstVideo->vimeo_id);
});
