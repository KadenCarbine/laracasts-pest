<?php

namespace App\Http\Controllers;

use App\Models\Video;

class PageVideoController extends Controller
{
    public function __invoke(Video $video)
    {
        return view('pages.course-videos', compact('video'));
    }
}
