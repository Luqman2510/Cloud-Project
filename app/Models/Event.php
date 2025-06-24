<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'start_date',
        'end_date',
        'start_time',
        'image',
        'address',
        'user_id',
        'location_id',
        'place_id',
        'num_attendees'
    ];

    protected $casts = [
        'start_date' => 'date:d/m/Y',
        'end_date' => 'date:d/m/Y',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function savedEvents(): HasMany
    {
        return $this->hasMany(SavedEvent::class);
    }

    public function attendings(): HasMany
    {
        return $this->hasMany(Attending::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function hasTag($tag)
    {
        return $this->tags->contains($tag);
    }
}
