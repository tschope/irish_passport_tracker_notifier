<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;
use App\Mail\PassportStatusMail;
use Illuminate\Support\Facades\Mail;

class PassportTracking extends Command
{
    protected $signature = 'passport:track {reference}';
    protected $description = 'Track the status of a passport application';

    private $stepOneUrl = 'https://passporttracking.dfa.ie/PassportTracking/';
    private $stepTwoUrl = 'https://passporttracking.dfa.ie/PassportTracking/Home/GetStep';
    private $requestToken = null;
    private $cookies = null;

    public function handle()
    {
        $reference = $this->argument('reference');
        $this->info("Tracking passport status for reference: $reference");

        if (!$this->setStepOne()) {
            $this->error('Failed to initialize tracking session.');
            return 1;
        }

        $statusData = $this->stepTwo($reference);
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
        }

        return 0;
    }

    private function setStepOne(): bool
    {
        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
            'Referer' => 'https://passporttracking.dfa.ie/PassportTracking/',
        ])->withOptions(['allow_redirects' => true])
            ->get($this->stepOneUrl);

        if ($response->ok()) {
            // Captura os cookies
            $this->cookies = $response->cookies();

            // Extrai o RequestVerificationToken
            $crawler = new Crawler($response->body());
            $token = $crawler->filter('input[name="__RequestVerificationToken"]')->attr('value');

            if ($token) {
                $this->requestToken = $token;
                return true;
            }
        }

        $this->error('Failed to complete step one. Response status: ' . $response->status());
        return false;
    }

    private function stepTwo(string $reference): ?array
    {
        if (!$this->requestToken || !$this->cookies) {
            $this->error('Request token or cookies are not set.');
            return null;
        }

        $formData = [
            '__RequestVerificationToken' => $this->requestToken,
            'search[Criteria][ReferenceNumber]' => $reference,
        ];

        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
            'Referer' => 'https://passporttracking.dfa.ie/PassportTracking/',
        ])->withOptions([
            'cookies' => $this->cookies,
            'allow_redirects' => true,
        ])->asForm()->post($this->stepTwoUrl, $formData);

        if ($response->ok()) {
            $crawler = new Crawler($response->body());
            // dump($response->body());

            // Extrai detalhes do progresso e alertas
            $progressContainer = $crawler->filter('div.progress-container');
            $statusDetails = $this->getProgressDetails($progressContainer);

            $tableRow = $crawler->filter('table.table tr')->first();
            $alertDetails = $this->getAlertDetails($tableRow);

            return array_merge($statusDetails, $alertDetails);
        }

        $this->error('Failed to complete step two. Response status: ' . $response->status());
        return null;
    }

    private function getExpectedDate(Crawler $crawler): ?string
    {
        $dateElement = $crawler->filter('div.status-date');

        if ($dateElement->count() > 0) {
            return $dateElement->text();
        }

        return null;
    }

    private function getCurrentStatus(Crawler $crawler): ?string
    {
        $table = $crawler->filter('table.table');

        if ($table->count() > 0) {
            $h2 = $table->filter('h2');
            $p = $table->filter('p');

            if ($h2->count() > 0) {
                return $h2->text() . ($p->count() > 0 ? ': ' . $p->text() : '');
            }
        }

        return null;
    }

    /**
     * Extrai os detalhes da progress-container.
     */
    private function getProgressDetails(Crawler $container): array
    {
        $details = [];
        if ($container->count() > 0) {
            $leftStatus = $container->filter('div.progress-tracking-left');
            $progressBar = $container->filter('div.progress-bar');
            $rightStatus = $container->filter('div.progress-tracking-right');

            $details['Application Received'] = $leftStatus->filter('div.status-date')->text('N/A');
            $details['Progress'] = $progressBar->attr('style') ?: 'N/A';
            $details['Right Status'] = $rightStatus->text('N/A');
        }

        return $details;
    }

    /**
     * Extrai os detalhes do alerta principal.
     */
    private function getAlertDetails(Crawler $tableRow): array
    {
        $details = [];
        if ($tableRow->count() > 0) {
            $date = $tableRow->filter('span.vertical-date small')->text('N/A');
            $title = $tableRow->filter('h2')->text('N/A');
            $message = $tableRow->filter('p')->text('N/A');

            $details['Alert Date'] = $date;
            $details['Alert Title'] = $title;
            $details['Alert Message'] = $message;
        }

        return $details;
    }
}
