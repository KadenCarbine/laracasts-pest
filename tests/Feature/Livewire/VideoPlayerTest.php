<?php

use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\User;
use App\Models\Video;

function createCourseWithVideos(int $count = 1): Course
{
    return Course::factory()
        ->has(Video::factory()->count($count))
        ->create();
}

it('shows details for a given video', function () {
    // Arrange
    $course = createCourseWithVideos();

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
    $course = createCourseWithVideos();

    // Act & Assert
    $firstVideo = $course->videos->first();
    Livewire::test(VideoPlayer::class, ['video' => $firstVideo])
        ->assertSeeHtml('<iframe src="https://player.vimeo.com/video/'.$firstVideo->vimeo_id);
});

it('shows list of all course videos', function () {
    // Arrange
    $course = createCourseWithVideos(3);

    // Act & Assert
    Livewire::test(VideoPlayer::class, ['video' => $course->videos()->first()])
        ->assertSee([...$course->videos->pluck('title')->toArray()])->assertSeeHtml([
            route('pages.course-videos', $course->videos[1]),
            route('pages.course-videos', $course->videos[2]),
        ]);
});

it('does not show link for current video', function () {
    // Arrange
    $course = createCourseWithVideos();
    // Act & Assert
    Livewire::test(VideoPlayer::class, ['video' => $course->videos()->first()])
        ->assertDontSeeHtml(route('pages.course-videos', $course->videos->first()));
});

it('marks video as completed', function () {
    // Arrange
    $user = User::factory()->create();
    $course = createCourseWithVideos();

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
    $course = createCourseWithVideos();

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
