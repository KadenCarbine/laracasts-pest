<?php

namespace App\Console\Commands;

use App\Models\Course;
use App\Services\Twitter\TwitterFacade;
use Illuminate\Console\Command;
class TweetAboutCourseReleaseCommand extends Command
{
    protected $signature = 'tweet:about-course-release {courseId}';

    protected $description = 'Tweet about the course release';

    public function handle(): void
    {
        $course = Course::findOrFail($this->argument('courseId'));

        TwitterFacade::tweet("I just released $course->title, Check it out!" . route('pages.course.details', $course));
    }
}
