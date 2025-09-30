<?php

use App\Models\Video;

it('gives back readable video duration', function () {
    // Arrange
    $video = Video::factory()->create(['duration_in_minutes' => 5]);

    // Act & Assert
    expect($video->getReadableDurationAttribute())->toEqual('5 minutes');
});
