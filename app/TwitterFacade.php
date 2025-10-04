<?php

namespace App;

use Illuminate\Support\Facades\Facade;
use Tests\Fakes\TwitterFake;

class TwitterFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'twitter';
    }

    public static function fake()
    {
        self::swap(new TwitterFake);
    }
}
