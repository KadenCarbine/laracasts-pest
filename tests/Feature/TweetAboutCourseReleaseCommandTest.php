<?php

use App\Console\Commands\TweetAboutCourseReleaseCommand;
use App\Models\Course;
use App\Services\Twitter\TwitterFacade;

it('tweets about release for provided course', function () {
    // Arrange
    TwitterFacade::fake();
    $course = Course::factory()->create();

    // Act
    $this->artisan(TweetAboutCourseReleaseCommand::class, ['courseId' => $course->id]);

    // Assert
    TwitterFacade::assertTweetSent("I just released $course->title, Check it out!" . route('pages.course.details', $course));
});
