<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationIdToEmail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'application_id_to_email';

    protected $fillable = [
        'applicationId',
        'email',
        'email_verified',
        'send_time_1',
        'send_time_2',
        'notification_days',
        'weekends',
    ];

    // Criptografando o email automaticamente
    protected $casts = [
        'email' => 'encrypted',
        'notification_days' => 'array',
    ];
}
