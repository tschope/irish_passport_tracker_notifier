<?php

namespace App\Console\Commands;

use App\Mail\PassportStatusRemoveMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Models\ApplicationIdToEmail;
use App\Models\UnsubscribeToken;
use App\Mail\PassportStatusMail;
use Tschope\PassportTrackingClient\PassportTrackingClient;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SendStatusUpdates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:send {time}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send status update emails for a specific time';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $time = $this->argument('time');
        $today = Carbon::now();
        $isWeekend = $today->isWeekend();

        // Buscar registros que correspondem ao horário e verificar finais de semana
        $records = ApplicationIdToEmail::where('email_verified', true)
            ->where(function ($query) use ($time) {
                $query->where('send_time_1', $time)
                    ->orWhere('send_time_2', $time);
            })
            ->where(function ($query) use ($isWeekend) {
                if ($isWeekend) {
                    $query->where('weekends', true);
                } else {
                    $query->where('weekends', true)
                        ->orWhere('weekends', false);
                }
            })
            ->get();

        if ($records->isEmpty()) {
            $this->info("No notifications to send at $time.");
            return 0;
        }

        $client = new PassportTrackingClient();

        foreach ($records as $record) {
            try {
                $applicationId = $record->applicationId;
                $statusData = $client->getStatus($applicationId);
                $email = Crypt::decrypt($record->email);

                if($statusData['error']) {
                    $this->error("Error processing Application ID: $record->applicationId. " . $statusData['message']);
                    Mail::to($email)->send(new PassportStatusRemoveMail(['Message' => $statusData['message']], $applicationId));

                    $record->delete();

                    continue;
                }

                if ($statusData) {
                    $this->info("Passport Tracking Status for Application ID: $applicationId");
                    foreach ($statusData as $key => $value) {
                        $this->line("$key: $value");
                    }

                    $unsubscribeToken = UnsubscribeToken::firstOrCreate(
                        ['applicationId' => $applicationId],
                        ['unsubscribe_token' => Str::random(40)]
                    );

                    Mail::to($email)->send(new PassportStatusMail($statusData, $applicationId, $unsubscribeToken->unsubscribe_token));

                    $this->info("Email sent successfully to $email!");
                } else {
                    $this->error("Unable to retrieve tracking data for Application ID: $applicationId. Email not sent.");
                }
            } catch (\Exception $e) {
                $this->error("Error processing Application ID: $record->applicationId. " . $e->getMessage());
            }
        }

        return 0;
    }
}
