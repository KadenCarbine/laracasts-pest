<?php

namespace App;

class TwitterClient
{
    protected array $tweets = [];
    public function __construct()
    {

    }
    // There is meant to be an actual twitter client here.
    public function tweet(string $status): array
    {
        $this->tweets[] = $status;
        return [
            'status' => $status,
        ];
    }
}
