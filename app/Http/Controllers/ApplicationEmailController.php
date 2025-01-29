<?php

namespace App\Http\Controllers;

use App\Models\ApplicationIdToEmail;
use App\Models\EmailVerification;
use App\Models\UnsubscribeToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\EmailVerificationMail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Validation\Rule;

class ApplicationEmailController extends Controller
{
    private $frontEndUrl;

    public function __construct()
    {
        $this->frontEndUrl = env('APP_FRONTEND_URL', '/');
    }

    // Armazenar novo registro
    public function store(Request $request)
    {
        $request->validate([
            'applicationId' => [
                'required',
                'numeric',
                'min:10000000000', // Definindo um valor mínimo (caso precise)
                'max:99999999999', // Definindo um valor máximo (caso precise)
                'unique:application_id_to_email,applicationId',
            ],
            'email' => 'required|email',
            'send_time_1' => 'required|date_format:H:i',
            'send_time_2' => 'nullable|date_format:H:i',
            'notification_days' => [
                'required',
                'array',
                Rule::in(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']),
            ],
            'weekends' => 'required|boolean',
        ], [
            'applicationId.required' => 'The Application ID field is required.',
            'applicationId.numeric' => 'The Application ID must be a valid number.',
            'applicationId.min' => 'The Application ID must have at least 11 digits.',
            'applicationId.max' => 'The Application ID cannot have more than 11 digits.',
            'applicationId.unique' => 'The Application ID is already registered.',

            'email.required' => 'The Email field is required.',
            'email.email' => 'The provided Email is not valid.',

            'send_time_1.required' => 'The Send Time 1 field is required.',
            'send_time_1.date_format' => 'The Send Time 1 must be in the format HH:MM.',

            'send_time_2.date_format' => 'The Send Time 2 must be in the format HH:MM.',

            'notification_days.required' => 'The Notification Days field is required.',
            'notification_days.array' => 'The Notification Days must be an array.',
            'notification_days.in' => 'The Notification Days must be one of the following: Monday, Tuesday, Wednesday, Thursday, Friday.',

            'weekends.required' => 'The Weekends field is required.',
            'weekends.boolean' => 'The Weekends field must be true or false.',
        ]);

        $data = $request->all();
        $data['email'] = encrypt($data['email']); // Criptografando o email
        $data['email_verified'] = false; // Marcar como não verificado inicialmente=

        $applicationEmail = ApplicationIdToEmail::create($data);

        // Gerar hash para verificação
        $verificationHash = Str::random(64); // Gerar uma string aleatória

        // Salvar na tabela de verificação
        EmailVerification::create([
            'applicationId' => $applicationEmail->applicationId,
            'hash' => $verificationHash,
            'expires_at' => now()->addHours(24), // Define a expiração, se necessário
        ]);

        // Enviar email com o link de verificação
        $verificationUrl = route('email.verify', ['hash' => $verificationHash]);

        Mail::to($request->email)->send(new EmailVerificationMail($verificationUrl));

        Log::info('Verification E-mail sent to Application ID: ' . $applicationEmail->applicationId);

        return response()->json($applicationEmail, 201); // Retorna o registro criado
    }

    public function getDetails(Request $request)
    {
        $request->validate([
            'applicationId' => [
                'required',
                'numeric',
                'min:10000000000', // Definindo um valor mínimo (caso precise)
                'max:99999999999', // Definindo um valor máximo (caso precise)
                'exists:application_id_to_email,applicationId',
            ],
            'email' => 'required|email',
        ], [
            'applicationId.required' => 'The Application ID field is required.',
            'applicationId.numeric' => 'The Application ID must be a valid number.',
            'applicationId.min' => 'The Application ID must have at least 11 digits.',
            'applicationId.max' => 'The Application ID cannot have more than 11 digits.',
            'applicationId.unique' => 'The Application ID not registered.',

            'email.required' => 'The Email field is required.',
            'email.email' => 'The provided Email is not valid.',
        ]);

        $data = $request->all();
        $applicationId = $data['applicationId'];

        $applicationDetails = ApplicationIdToEmail::where('applicationId', $applicationId)->first();

        $emailDecrypted = Crypt::decrypt($applicationDetails->email);

        if ($emailDecrypted !== $data['email']) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        $return = [
            'applicationId' => $applicationDetails->applicationId,
            'email' => $emailDecrypted,
            'send_time_1' => $applicationDetails->send_time_1,
            'send_time_2' => $applicationDetails->send_time_2,
            'notification_days' =>  $applicationDetails->notification_days,
            'weekends' =>  $applicationDetails->weekends,
        ];

        return response()->json($return, 200); // Retorna o registro atualizado
    }

    // Atualizar registro existente
    public function update(Request $request, $applicationId)
    {
        $request->validate([
            'email' => 'required|email',
            'send_time_1' => 'required|date_format:H:i',
            'send_time_2' => 'nullable|date_format:H:i',
            'notification_days' => [
                'required',
                'array',
                Rule::in(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']),
            ],
            'weekends' => 'required|boolean',
        ]);

        $applicationEmail = ApplicationIdToEmail::where('applicationId', $applicationId)->first();

        if (!$applicationEmail) {
            return response()->json(['message' => 'Registro não encontrado'], 404);
        }

        $data = $request->all();
        $data['email'] = encrypt($data['email']); // Criptografando o email

        $applicationEmail->update($data);
        Log::info("Application ID $applicationEmail->applicationId updates their information.");

        return response()->json($applicationEmail, 200); // Retorna o registro atualizado
    }

    // Deletar registro
    public function unsubscribeForm(Request $request)
    {
        $request->validate([
            'applicationId' => 'required|string',
            'email' => 'required|email',
        ]);

        $record = ApplicationIdToEmail::where('applicationId', $request->applicationId)
            ->first();

        if (!$record) {
            return response()->json(['success' => false, 'message' => 'Record not found.']);
        }

        $email = Crypt::decrypt($record->email);

        if ($request->email !== $email) {
            return response()->json(['success' => false, 'message' => 'Record not found.']);
        }

        $record->delete();
        Log::info("Application ID $record->applicationId decide to not receive anymore updates.");

        return response()->json(['success' => true, 'message' => 'Unsubscribed successfully.']);
    }

    public function verifyEmail($hash): \Illuminate\Http\Response
    {
        $verification = EmailVerification::where('hash', $hash)->first();

        if (!$verification) {
            return response()->view('emails.verification_error', ['message' => 'Invalid hash'], 404)
                ->header('Refresh', '5;url='.$this->frontEndUrl);
        }

        // Verificar se a hash não expirou
        if ($verification->expires_at && $verification->expires_at < now()) {
            return response()->view('emails.verification_error', ['message' => 'Hash expired'], 410)
                ->header('Refresh', '5;url='.$this->frontEndUrl);
        }

        // $applicationEmail = ApplicationIdToEmail::where('id', $verification->applicationId)->first();
        $applicationEmail = ApplicationIdToEmail::where('applicationId', $verification->applicationId)->first();
        if (!$applicationEmail) {
            $verification->delete();

            return response()->view('emails.verification_error', ['message' => 'Application ID not found'], 404)
                ->header('Refresh', '5;url='.$this->frontEndUrl);
        }

        // Atualizar o campo email_verified na tabela de application_id_to_email
        $applicationEmail->email_verified = true;
        $applicationEmail->save();

        Log::info('E-mail verified. Sending first email to Application ID: ' . $applicationEmail->applicationId);

        // Disparar o comando Artisan para rastrear o passaporte
        Artisan::call('passport:track', [
            'reference' => $verification->applicationId,
        ]);

        // Apagar o registro de verificação
        $verification->delete();

        // Retornar a resposta com mensagem e redirecionamento após 5 segundos
        return response()->view('emails.verification_success', ['message' => 'Email successfully verified!'])
            ->header('Refresh', '5;url='.$this->frontEndUrl);
    }

    public function unsubscribe($token): \Illuminate\Http\Response
    {
        // Verifica se o token é válido
        $unsubscribeToken = UnsubscribeToken::where('unsubscribe_token', $token)->first();

        if (!$unsubscribeToken) {
            return response()->view('emails.verification_error', ['message' => 'Invalid token'], 404)
                ->header('Refresh', '5;url='.$this->frontEndUrl);
        }

        // Remove o registro da tabela application_id_to_email
        ApplicationIdToEmail::where('applicationId', $unsubscribeToken->applicationId)->delete();

        // Remove o token de descadastramento
        $unsubscribeToken->delete();
        Log::info("Application ID $unsubscribeToken->applicationId decide to not receive anymore updates.");

        return response()->view('emails.verification_success', ['message' => 'You have successfully unsubscribed from notifications'])
            ->header('Refresh', '5;url='.$this->frontEndUrl);
    }
}
