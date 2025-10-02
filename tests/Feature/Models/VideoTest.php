<?php

use App\Models\Course;
use App\Models\Video;

it('belongs to a course', function () {
    // Arrange
    $video = Video::factory()
        ->has(Course::factory())
        ->create();
    // Act & Assert
    expect($video->course)->toBeInstanceOf(Course::class);
});

it('gives back readable video duration', function () {
    // Arrange
    $video = Video::factory()->create(['duration_in_minutes' => 5]);

    // Act & Assert
    expect($video->getReadableDurationAttribute())->toEqual('5 minutes');
});
