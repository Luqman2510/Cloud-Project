<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function places(): HasMany
    {
        return $this->hasMany(Place::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
