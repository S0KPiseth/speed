<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as ElQ_MODEL;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Maker extends ElQ_MODEL

{
    protected $fillable = ["name"];
    public $timestamps = false;
    public function model(): HasMany
    {
        return $this->hasMany(Model::class);
    }   //
    public function car(): HasMany
    {
        return $this->hasMany(Car::class);
    }
}
