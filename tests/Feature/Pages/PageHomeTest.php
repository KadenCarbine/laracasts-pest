<?php

use App\Models\Course;
use Illuminate\Support\Carbon;

use function Pest\Laravel\get;

it('shows courses overview', function () {
    // Arrange
    $firstCourse = Course::factory()->create();
    $secondCourse = Course::factory()->create();
    $thirdCourse = Course::factory()->create();
    // Act & Assert
    get(route('pages.home'))
        ->assertSeeText([
            $firstCourse->title,
            $firstCourse->description,
            $secondCourse->title,
            $secondCourse->description,
            $thirdCourse->title,
            $thirdCourse->description,
        ]);
});

it('shows only released courses', function () {
    // Arrange
    $releasedCourse = Course::factory()->create();
    $notReleasedCourse = Course::factory()->create(['released_at' => null]);
    // Act & Assert
    get(route('pages.home'))
        ->assertSeeText([
            $releasedCourse->title,
            $releasedCourse->description,
        ])
        ->assertDontSeeText([
            $notReleasedCourse->title,
            $notReleasedCourse->description,
        ]);
});

it('shows courses by release date', function () {
    // Arrange
    $oldCourse = Course::factory()->create();
    $newestCourse = Course::factory()->create(['released_at' => Carbon::now()]);
    // Act & Assert
    get(route('pages.home'))
        ->assertSeeInOrder([
            $newestCourse->title,
            $oldCourse->title,
        ]);
});

it('includes login if not logged in', function () {
    // Act &  Assert
    get(route('pages.home'))
        ->assertOk()
        ->assertSeeText('Login')
        ->assertSee(route('login'));
});

it('includes logout if logged in', function () {
    // Arrange
    loginAsUser();
    // Act &  Assert
    get(route('pages.home'))
        ->assertOk()
        ->assertSeeText('Log out')
        ->assertSee(route('logout'));
});
