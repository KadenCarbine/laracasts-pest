<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Support\Carbon;

class PageHomeController extends Controller
{
    public function __invoke()
    {
        $courses = Course::query()
            ->where('courses.released_at', '<=', Carbon::now())
            ->orderBy('courses.released_at', 'desc')
            ->get();
        return view('home', compact('courses'));
    }
}
