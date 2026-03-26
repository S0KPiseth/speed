<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AccountVerify extends Model
{
    protected $table = 'account_verification';
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function verificationRequest():HasMany
    {
        return $this->hasMany(VerificationRequest::class);
    }
    public function idVerificationRequest():HasOne
    {
        return $this->hasOne(IdVerificationRequest::class);
    }
}
