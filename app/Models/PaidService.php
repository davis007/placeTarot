<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaidService extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'practitioner_id',
        'title',
        'description',
        'points',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'points' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the practitioner that owns the paid service.
     */
    public function practitioner()
    {
        return $this->belongsTo(User::class, 'practitioner_id');
    }

    /**
     * Scope a query to only include active services.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
