<?php

use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Sequence;

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
        ->assertSeeHtml('<iframe src="https://player.vimeo.com/video/'.$firstVideo->vimeo_id);
});

it('shows list of all course videos', function () {
    // Arrange
    $course = Course::factory()
        ->has(Video::factory(3)->state(new Sequence(
            ['title' => 'First Video'],
            ['title' => 'Second Video'],
            ['title' => 'Third Video'],
        )))->create();
    // Act & Assert
    Livewire::test(VideoPlayer::class, ['video' => $course->videos()->first()])
        ->assertSee([
            'First Video',
            'Second Video',
            'Third Video',
        ])->assertSeeHtml([
            route('pages.course-videos', Video::where('title', 'First Video')->first()),
            route('pages.course-videos', Video::where('title', 'Second Video')->first()),
            route('pages.course-videos', Video::where('title', 'Third Video')->first()),
        ]);
});
