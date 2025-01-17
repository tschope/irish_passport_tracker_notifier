<?php

namespace App\Console\Commands;

use App\Mail\PassportStatusRemoveMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
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
        $currentDay = $today->format('l'); // Exemplo: "Monday", "Tuesday", etc.
        $isWeekend = $today->isWeekend();
        $time = strlen($time) === 4 ? '0' . $time : $time;

        // Buscar registros que correspondem ao horário e verificar finais de semana e dias permitidos
        $records = ApplicationIdToEmail::where('email_verified', true)
            ->where(function ($query) use ($time) {
                $query->where('send_time_1', $time)
                    ->orWhere('send_time_2', $time);
            })
            ->where(function ($query) use ($currentDay, $isWeekend) {
                $query->whereJsonContains('notification_days', $currentDay)
                    ->orWhere(function ($subQuery) use ($isWeekend) {
                        $subQuery->where('weekends', true)->whereRaw($isWeekend ? '1=1' : '0=1');
                    });
            })
            ->get();

        if ($records->isEmpty()) {
            $this->info("No notifications to send at $time.");
            Log::info("No notifications to send at $time.");
            return 0;
        }

        $client = new PassportTrackingClient();

        foreach ($records as $record) {
            try {
                $applicationId = $record->applicationId;
                $statusData = $client->getStatus($applicationId);
                $email = Crypt::decrypt($record->email);

                if(!empty($statusData['error'])) {
                    $this->error("Error processing Application ID: $record->applicationId. " . $statusData['message']);
                    Mail::to($email)->send(new PassportStatusRemoveMail(['Message' => $statusData['message']], $applicationId));

                    $record->delete();
                    Log::info("Application ID $record->applicationId has been removed from database");

                    continue;
                }

                if ($statusData) {
                    $this->info("Passport Tracking Status for Application ID: $applicationId");

                    $unsubscribeToken = UnsubscribeToken::firstOrCreate(
                        ['applicationId' => $applicationId],
                        ['unsubscribe_token' => Str::random(40)]
                    );

                    Mail::to($email)->send(new PassportStatusMail($statusData, $applicationId, $unsubscribeToken->unsubscribe_token));

                    if ($statusData['progress'] === 100.0) {
                        $record->delete();
                        Log::info("Application ID $record->applicationId has been removed from database because it has been completed");
                    }

                    Log::info("Passport Tracking Status for Application ID: $applicationId has been sent via email");
                } else {
                    $this->error("Unable to retrieve tracking data for Application ID: $applicationId. Email not sent.");
                    Log::error("Unable to retrieve tracking data for Application ID: $applicationId. Email not sent.");
                }
            } catch (\Exception $e) {
                $this->error("Error processing Application ID: $record->applicationId. " . $e->getMessage());
                Log::error("Error processing Application ID: $record->applicationId. " . $e->getMessage());
            }
        }

        return 0;
    }
}
