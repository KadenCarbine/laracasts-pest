<div>
    <iframe src="https://player.vimeo.com/video/{{ $video->vimeo_id }}" class="w-full aspect-video rounded mb-4 md:mb-8" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
    <h3>{{ $video->title }} <small>({{ $video->getReadableDurationAttribute() }})</small></h3>
    <p>{{ $video->description }}</p>
    <ul>
        @foreach($courseVideos as $courseVideo)
            <li>
                <a href="{{ route('pages.course-videos', $courseVideo) }}">
                {{ $courseVideo->title }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
