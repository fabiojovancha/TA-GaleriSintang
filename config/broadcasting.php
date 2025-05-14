<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Broadcast Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default broadcast driver that will be used
    | by your application to send broadcast events. The supported drivers
    | are: "pusher", "redis", "log", "null". You may choose one of these
    | drivers to control how your broadcast events will be sent out.
    |
    */

    'default' => env('BROADCAST_DRIVER', 'pusher'),

    /*
    |--------------------------------------------------------------------------
    | Broadcast Connections
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the connections that should be used for
    | broadcasting events. A great option for pushing events to websockets
    | is to use Pusher or Redis. Feel free to modify these options as needed.
    |
    | Supported: "pusher", "redis", "log", "null"
    |
    */

    'connections' => [

        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'encrypted' => true,
            ],
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],

        'log' => [
            'driver' => 'log',
            'channel' => env('BROADCAST_LOG_CHANNEL'),
        ],

        'null' => [
            'driver' => 'null',
        ],

    ],

];
