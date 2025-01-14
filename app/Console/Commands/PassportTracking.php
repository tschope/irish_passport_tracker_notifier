<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\PassportStatusMail;
use Illuminate\Support\Facades\Mail;
use Tschope\PassportTrackingClient\PassportTrackingClient;

class PassportTracking extends Command
{
    protected $signature = 'passport:track {reference}';
    protected $description = 'Track the status of a passport application';

    public function handle()
    {
        $reference = $this->argument('reference');
        $this->info("Tracking passport status for reference: $reference");

        $client = new PassportTrackingClient();
        $statusData = $client->getStatus($reference);

        if ($statusData) {
            $this->info('Passport Tracking Status:');
            foreach ($statusData as $key => $value) {
                $this->line("$key: $value");
            }

            $this->info('Sending status update via email...');

            Mail::to('tschope@gmail.com')->send(new PassportStatusMail($statusData));

            $this->info('Email sent successfully!');

        } else {
            $this->error('Unable to retrieve tracking data. Email not sent.');
            return 0;
        }

        return 1;

    }
}
