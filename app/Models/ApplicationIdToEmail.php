<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationIdToEmail extends Model
{
    use HasFactory;

    protected $table = 'application_id_to_email';

    protected $fillable = [
        'applicationId',
        'email',
        'email_verified',
        'send_time_1',
        'send_time_2',
        'weekends',
    ];

    // Criptografando o email automaticamente
    protected $casts = [
        'email' => 'encrypted',
    ];
}
