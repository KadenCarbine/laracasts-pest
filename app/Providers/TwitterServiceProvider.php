<?php

namespace App\Providers;

use App\Services\Twitter\TwitterClient;
use Illuminate\Support\ServiceProvider;

class TwitterServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('twitter', function () {
            return app(TwitterClient::class);
        });
    }

    public function boot(): void
    {
    }
}
