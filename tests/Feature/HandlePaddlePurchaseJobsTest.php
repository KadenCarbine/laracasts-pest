<?php

use App\Jobs\HandlePaddlePurchaseJob;
use App\Mail\newPurchaseMail;
use App\Models\Course;
use App\Models\PurchasedCourse;
use App\Models\User;
use Spatie\WebhookClient\Models\WebhookCall;

beforeEach(function () {
    $this->webhookCall = WebhookCall::create([
        'name' => 'default',
        'url' => 'http://example.com/',
        'payload' => [
            'email' =>'test@example.com',
            'name' => 'Test User',
            'paddle_product_id' => '34779',
        ]
    ]);
});

it('stores paddle purchase', function () {
    // Assert
    Mail::fake();

    $this->assertDatabaseEmpty(User::class);
    $this->assertDatabaseEmpty(PurchasedCourse::class);

    // Arrange
    $course = Course::factory()->create(['paddle_product_id' => '34779']);

    // Act & Assert
    (new HandlePaddlePurchaseJob($this->webhookCall))->handle();

    $this->assertDatabaseHas(User::class, [
        'email' => 'test@example.com',
        'name' => 'Test User',
    ]);

    $user = User::query()->first();
    $this->assertDatabaseHas(PurchasedCourse::class, [
        'user_id' => $user->id,
        'course_id' => $course->id,
    ]);

});

it('stores paddle purchase for given user', function () {

    // Arrange
    Mail::fake();

    $user = User::factory()->create(['email' => 'test@example.com']);
    $course = Course::factory()->create(['paddle_product_id' => '34779']);

    // Act & Assert
    (new HandlePaddlePurchaseJob($this->webhookCall))->handle();
    $this->assertDatabaseCount(User::class, 1);
    $this->assertDatabaseHas(User::class, [
        'email' => $user->email,
        'name' => $user->name,
    ]);

    $this->assertDatabaseHas(PurchasedCourse::class, [
        'user_id' => $user->id,
        'course_id' => $course->id,
    ]);
});

it('sends out purchase email', function () {
    // Arrange
    Mail::fake();
    Course::factory()->create(['paddle_product_id' => '34779']);
    // Act & Assert
    (new HandlePaddlePurchaseJob($this->webhookCall))->handle();

    Mail::assertSent(newPurchaseMail::class);
});
