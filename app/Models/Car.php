<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as ElQ_MODEL;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Car extends ElQ_MODEL
{
    protected $guarded = [
        'is_feature',
        'is_hot',
        'is_new_arrival'
    ];
    public function feature()
    {
        return $this->hasOne(CarFeature::class);
    }    //
    public function primaryImage()
    {
        return $this->hasOne(CarImage::class)
            ->oldestOfMany('position');
    }
    public function images(): HasMany
    {
        return $this->hasMany(CarImage::class);
    }
    public function carType(): BelongsTo
    {
        return $this->belongsTo(CarType::class);
    }
    public function favoriteUser(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorite_cars');
    }
    public function model(): BelongsTo
    {
        return $this->belongsTo(Model::class);
    }

    public function maker(): BelongsTo
    {
        return $this->belongsTo(Maker::class);
    }
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
    public function fuelType(): BelongsTo
    {
        return $this->belongsTo(FuelType::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
