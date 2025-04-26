<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBadge extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'badge_id',
        'acquired_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'acquired_at' => 'datetime',
    ];

    /**
     * Get the user that owns the badge.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the badge that belongs to the user.
     */
    public function badge()
    {
        return $this->belongsTo(Badge::class);
    }
}
