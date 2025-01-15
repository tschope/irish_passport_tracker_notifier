<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Schedule::command('passport:track {reference}')->twiceDaily(8, 18);

$times = ['8:00', '10:00', '13:00', '16:00', '18:00'];

foreach ($times as $time) {
    Schedule::command("notifications:send $time")
        ->timezone('Europe/Dublin')
        ->at($time);
}
