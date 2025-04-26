<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',
        'practitioner_id',
        'title',
        'question',
        'status',
        'is_paid',
        'points_used',
        'completed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_paid' => 'boolean',
        'points_used' => 'integer',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the client that owns the consultation.
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Get the practitioner that owns the consultation.
     */
    public function practitioner()
    {
        return $this->belongsTo(User::class, 'practitioner_id');
    }

    /**
     * Get the messages for the consultation.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get the review for the consultation.
     */
    public function review()
    {
        return $this->hasOne(Review::class);
    }

    /**
     * Scope a query to only include pending consultations.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include accepted consultations.
     */
    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    /**
     * Scope a query to only include in-progress consultations.
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    /**
     * Scope a query to only include completed consultations.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include rejected consultations.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Scope a query to only include cancelled consultations.
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }
}
