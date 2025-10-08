<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarType extends Model
{
    public function car(): HasMany
    {
        return $this->hasMany(Car::class);
    }
}
