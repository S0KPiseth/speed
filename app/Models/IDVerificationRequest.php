<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IDVerificationRequest extends Model
{
    protected $table = 'id_verification_request';

    protected $fillable = [
        'user_id',
        'status',
        'id_front_url',
        'id_back_url',
        'id_front_file_id',
        'id_back_file_id',
        'rejection_reason',
        'admin_id',
    ];
}
