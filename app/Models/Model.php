<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Model extends EloquentModel
{
    public function maker(): BelongsTo
    {
        return $this->belongsTo(Maker::class);
    }
    public function car(): HasMany
    {
        return $this->hasMany(Car::class);
    }
}
