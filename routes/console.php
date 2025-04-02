<?php

use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

$times = ['08:00', '10:00', '13:00', '16:00', '18:00'];

foreach ($times as $time) {
    $utcTime = Carbon::parse($time, 'Europe/Dublin')->setTimezone('UTC')->format('H:i');

    Schedule::command("notifications:send $time")
        ->timezone('UTC')
        ->at($utcTime);
}
