<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarImage extends Model

{
    protected $fillable = ['image_path', 'position', 'car_id', 'image_id'];
    public $timestamps = false;
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }   //
}
