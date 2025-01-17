<?php

namespace App\Console\Commands;

use App\Mail\PassportStatusRemoveMail;
use App\Models\ApplicationIdToEmail;
use App\Models\UnsubscribeToken;
use Illuminate\Console\Command;
use App\Mail\PassportStatusMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tschope\PassportTrackingClient\PassportTrackingClient;
use Illuminate\Support\Facades\Crypt;

class PassportTracking extends Command
{
    protected $signature = 'passport:track {reference}';
    protected $description = 'Track the status of a passport application';

    public function handle()
    {
        $reference = $this->argument('reference');
        $this->info("Tracking passport status for reference: $reference");
        Log::info('Tracking passport status for reference: ' . $reference);

        $client = new PassportTrackingClient();
        $statusData = $client->getStatus($reference);

        $user = ApplicationIdToEmail::where('applicationId', $reference)->first();
        $email = Crypt::decrypt($user->email);

        if(!empty($statusData['error'])) {
            $this->error("Error processing Application ID: $reference. " . $statusData['message']);
            Mail::to($email)->send(new PassportStatusRemoveMail(['Message' => $statusData['message']], $reference));

            $user->delete();
            Log::error("Error processing Application ID: $reference. " . $statusData['message']);

            return 0;
        }

        if ($statusData) {
            $this->info('Passport Tracking Status:');

            $this->info('Sending status update via email...');

            $unsubscribeToken = UnsubscribeToken::firstOrCreate(
                ['applicationId' => $reference],
                ['unsubscribe_token' => Str::random(40)]
            );

            Mail::to($email)->send(new PassportStatusMail($statusData, $reference, $unsubscribeToken->unsubscribe_token));

            if ($statusData['progress'] === 100.0) {
                $user->delete();
                Log::info("Application ID $reference has been removed from database because it has been completed");
            }

            $this->info('Email sent successfully!');
            Log::info('First Status Email sent successfully! Application ID: ' . $reference);

        } else {
            $this->error('Unable to retrieve tracking data. Email not sent.');
            Log::error('Unable to retrieve tracking data. Email not sent. Application ID: ' . $reference);
            return 0;
        }

        return 1;

    }
}
