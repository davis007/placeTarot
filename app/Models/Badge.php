<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'required_points',
        'icon',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'required_points' => 'integer',
    ];

    /**
     * The users that belong to the badge.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_badges')
                    ->withPivot('acquired_at')
                    ->withTimestamps();
    }
}
