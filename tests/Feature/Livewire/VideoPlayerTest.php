<?php

use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\User;
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
        ->has(Video::factory(3))->create();
    // Act & Assert
    Livewire::test(VideoPlayer::class, ['video' => $course->videos()->first()])
        ->assertSee([...$course->videos->pluck('title')->toArray()])->assertSeeHtml([
            route('pages.course-videos', $course->videos[0]),
            route('pages.course-videos', $course->videos[1]),
            route('pages.course-videos', $course->videos[2]),
        ]);
});

it('marks video as completed', function () {
    // Arrange
    $user = User::factory()->create();
    $course = Course::factory()
        ->has(Video::factory())
        ->create();

    $user->purchasedCourses()->attach($course);
    // Assert
    expect($user->watchedVideos)->toHaveCount(0);
    // Act & Assert
    loginAsUser($user);
    Livewire::test(VideoPlayer::class, ['video' => $course->videos()->first()])
        ->call('markVideoAsCompleted');

    $user->refresh();
    expect($user->watchedVideos)->toHaveCount(1)
        ->first()->title->toEqual($course->videos->first()->title);
});

it('marks video as not completed', function () {
    // Arrange
    $user = User::factory()->create();
    $course = Course::factory()
        ->has(Video::factory())
        ->create();

    $user->purchasedCourses()->attach($course);
    $user->watchedVideos()->attach($course->videos()->first());
    // Assert
    expect($user->watchedVideos)->toHaveCount(1);
    // Act & Assert
    loginAsUser($user);
    Livewire::test(VideoPlayer::class, ['video' => $course->videos()->first()])
        ->call('markVideoAsNotCompleted');

    $user->refresh();
    expect($user->watchedVideos)->toHaveCount(0);
});
