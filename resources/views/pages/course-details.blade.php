<h2>{{ $course->title }}</h2>
<h3>{{ $course->tagline }}</h3>
<p> {{ $course->description }}</p>
<p> {{ $course->videos_count  }} Videos</p>
<ul>
    @foreach($course->learnings as $learning)
        <li>{{ $learning }}</li>
    @endforeach
</ul>

<img src="{{ asset("images/$course->image_name")  }}" alt="Image of the course {{ $course->title }}">
<a href="#!" class="paddle_button" data-product="{{ $course->paddle_product_id }}">Buy Now!</a>
<script src="https://cdn.paddle.com/paddle/paddle.js"></script>
<script type="text/javascript">
    @env('local')
    Paddle.Environment.set("sandbox")
    @endenv
    Paddle.Setup({ vendor: 4576 });
</script>
