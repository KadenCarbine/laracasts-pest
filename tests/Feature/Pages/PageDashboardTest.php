<?php

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Carbon;

use function Pest\Laravel\get;

it('cannot be accessed by a guest', function () {
    // Act &  Assert
    get(route('pages.dashboard'))
        ->assertRedirect(route('login'));
});

it('lists purchased courses', function () {
    // Arrange
    $user = User::factory()
        ->has(Course::factory(2), 'purchasedCourses')
        ->create();
    // Act
    loginAsUser($user);
    // Assert
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeText(...$user->purchasedCourses->pluck('name'));
});

it('does not list any other courses', function () {
    // Arrange
    $course = Course::factory()->create();
    // Act
    loginAsUser();
    // Assert
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertDontSee($course->title);
});

it('shows latest purchased course first', function () {
    // Arrange
    $user = User::factory()->create();
    $firstPurchasedCourse = Course::factory()->create();
    $lastPurchasedCourse = Course::factory()->create();

    $user->purchasedCourses()->attach($firstPurchasedCourse, ['created_at' => Carbon::yesterday()]);
    $user->purchasedCourses()->attach($lastPurchasedCourse, ['created_at' => Carbon::now()]);
    // Act
    loginAsUser($user);
    // Assert
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeTextInOrder([
            $lastPurchasedCourse->title,
            $firstPurchasedCourse->title,
        ]);
});

it('includes link to product videos', function () {
    // Arrange
    $user = User::factory()
        ->has(Course::factory(), 'purchasedCourses')
        ->create();
    // Act
    loginAsUser($user);
    // Assert
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeText('Watch Videos')
        ->assertSee(route('pages.course-videos', Course::first()));
});

it('includes logout', function () {
    // Arrange
    loginAsUser();
    // Act & Assert
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeText('Log Out')
        ->assertSee(route('logout'));
});
