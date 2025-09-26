<?php

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('cannot be accessed by a guest', function () {
    // Act &  Assert
    get(route('dashboard'))
        ->assertRedirect(route('login'));
});

it('lists purchased courses', function () {
    // Arrange
    $user = User::factory()
        ->has(Course::factory(2)->state(
            new Sequence(
                ['title' => 'Course A'],
                ['title' => 'Course B'],
            )
        ))
        ->create();
    // Act
    $this->actingAs($user);
    // Assert
    get(route('dashboard'))
        ->assertOk()
        ->assertSeeText([
            'Course A',
            'Course B',
        ]);
});

it('does not list any other courses', function () {
    // Arrange
    $user = User::factory()->create();
    $course = Course::factory()->create();
    // Act
    $this->actingAs($user);
    // Assert
    get(route('dashboard'))
        ->assertOk()
        ->assertDontSee($course->title);
});

it('shows latest purchased course first', function () {
    // Arrange
    $user = User::factory()->create();
    $firstPurchasedCourse = Course::factory()->create();
    $lastPurchasedCourse = Course::factory()->create();

    $user->courses()->attach($firstPurchasedCourse, ['created_at' => Carbon::yesterday()]);
    $user->courses()->attach($lastPurchasedCourse, ['created_at' => Carbon::now()]);
    // Act
    $this->actingAs($user);
    // Assert
    get(route('dashboard'))
        ->assertOk()
        ->assertSeeTextInOrder([
            $lastPurchasedCourse->title,
            $firstPurchasedCourse->title,
        ]);
});

it('includes link to product videos', function () {
    // Arrange
    $user = User::factory()
        ->has(Course::factory())
        ->create();
    // Act
    $this->actingAs($user);
    // Assert
    get(route('dashboard'))
        ->assertOk()
        ->assertSeeText('Watch Videos')
        ->assertSee(route('page.course-videos', Course::first()));
});
