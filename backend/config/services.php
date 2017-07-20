<?php

return [

    'github' => [
        'client_id' => env('GITHUB_APP_ID'),
        'client_secret' => env('GITHUB_APP_SECRET'),
        'redirect' => env('GITHUB_APP_CALLBACK'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_APP_ID'),
        'client_secret' => env('FACEBOOK_APP_SECRET'),
        'redirect' => env('FACEBOOK_APP_CALLBACK'),
        'defaulft' => [
            'public_profile',
            'user_events',
            'user_likes',
            'user_posts',
            'user_videos'
        ]
     ],


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
        'client_id' => env('YOUTUBE_APP_ID'),
        'client_secret' => env('YOUTUBE_APP_SECRET'),
        'redirect' => env('YOUTUBE_APP_CALLBACK'),
    ],
];
