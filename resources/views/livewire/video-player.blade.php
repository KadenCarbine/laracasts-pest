<div>
    <iframe src="https://player.vimeo.com/video/{{ $video->vimeo_id }}" class="w-full aspect-video rounded mb-4 md:mb-8" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
    <h3>{{ $video->title }} <small>({{ $video->getReadableDurationAttribute() }})</small></h3>
    <p>{{ $video->description }}</p>
    @if($video->alreadyWatched())
        <button wire:click="markVideoAsNotCompleted">Mark as Not Completed</button>
    @else
        <button wire:click="markVideoAsCompleted">Mark as Completed</button>
    @endif
    <ul>
        @foreach($courseVideos as $courseVideo)
            <li>
                @if($this->video->is($courseVideo))
                    {{ $courseVideo->title }}
                @else
                    <a href="{{ route('pages.course-videos', ['course' => $courseVideo->course, 'video' => $courseVideo]) }}">
                        {{ $courseVideo->title }}
                    </a>
                @endif
            </li>
        @endforeach
    </ul>
</div>
