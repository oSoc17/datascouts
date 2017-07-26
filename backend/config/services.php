<?php

return [

    /**
     *
     * If you don't have credentials yet, head over to https://apps.twitter.com/
     *
     */

    'twitter' => [
        'client_id' => env('TWITTER_APP_ID'),
        'client_secret' => env('TWITTER_APP_SECRET'),
        'access_token' => env('TWITTER_APP_ACCESS_TOKEN'),
        'access_token_secret' => env('TWITTER_APP_ACCESS_TOKEN_SECRET'),
        'redirect' => env('TWITTER_APP_CALLBACK')
    ],
    
    
    'google' => [
        'client_id' => env('GOOGLE_APP_ID'),
        'client_secret' => env('GOOGLE_APP_SECRET'),
        'redirect' => env('GOOGLE_APP_CALLBACK'),
    ],
    
    'youtube' => [
        'api_key' => env('YOUTUBE_API_KEY'),
        'client_id' => env('YOUTUBE_APP_ID'),
        'client_secret' => env('YOUTUBE_APP_SECRET'),
        'redirect' => env('YOUTUBE_APP_CALLBACK'),
    ],

    'vimeo' => [
        'client_id' => env('VIMEO_APP_ID'),
        'client_secret' => env('VIMEO_APP_SECRET'),
        'access_token' => env('VIMEO_APP_ACCESS_TOKEN'),
        'default_scope' => ['public', 'private', 'purchased', 'interact'],
        'redirect' => env('VIMEO_APP_CALLBACK'),
    ],

];
