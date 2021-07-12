<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Binaries
    |--------------------------------------------------------------------------
    |
    | Paths to ffmpeg nad ffprobe binaries
    |
    */

    'binaries' => [
        'ffmpeg'  => env('FFMPEG', '/var/www/vhosts/elaunchinfotech.com/pollzilla.elaunchinfotech.com/ffmpeg'),
        'ffprobe' => env('FFPROBE', '/var/www/vhosts/elaunchinfotech.com/pollzilla.elaunchinfotech.com/ffprobe')
    ]
];