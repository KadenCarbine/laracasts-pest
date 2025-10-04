<?php

use App\Jobs\HandlePaddlePurchaseJob;
use App\Models\Course;
use App\Models\PurchasedCourse;
use App\Models\User;
use Spatie\WebhookClient\Models\WebhookCall;

it('stores paddle purchase', function () {
    // Assert
    $this->assertDatabaseEmpty(User::class);
    $this->assertDatabaseEmpty(PurchasedCourse::class);

    // Arrange
    $course = Course::factory()->create(['paddle_product_id' => '34779']);
    $webhookCall = WebhookCall::create([
       'name' => 'default',
       'url' => 'http://example.com/',
       'payload' => [
           'email' =>'test@example.com',
           'name' => 'Test User',
           'paddle_product_id' => '34779',
       ]
    ]);

    // Act & Assert
    (new HandlePaddlePurchaseJob($webhookCall))->handle();

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

    // Act & Assert
});

it('sends out purchase email', function () {
    // Arrange

    // Act & Assert
});
