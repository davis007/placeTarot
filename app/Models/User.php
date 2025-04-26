<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'google_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the profile associated with the user.
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Get the consultations where the user is a client.
     */
    public function clientConsultations()
    {
        return $this->hasMany(Consultation::class, 'client_id');
    }

    /**
     * Get the consultations where the user is a practitioner.
     */
    public function practitionerConsultations()
    {
        return $this->hasMany(Consultation::class, 'practitioner_id');
    }

    /**
     * Get the messages sent by the user.
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Get the messages received by the user.
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Get all messages (sent and received) for the user.
     *
     * @deprecated Use sentMessages() or receivedMessages() instead.
     */
    public function messages()
    {
        return $this->sentMessages();
    }

    /**
     * Get the reviews received by the user as a practitioner.
     */
    public function receivedReviews()
    {
        return $this->hasMany(Review::class, 'practitioner_id');
    }

    /**
     * Get the reviews given by the user as a client.
     */
    public function givenReviews()
    {
        return $this->hasMany(Review::class, 'client_id');
    }

    /**
     * Get the points record for the user.
     */
    public function points()
    {
        return $this->hasOne(Point::class);
    }

    /**
     * Get the point transactions for the user.
     */
    public function pointTransactions()
    {
        return $this->hasMany(PointTransaction::class);
    }

    /**
     * Get the badges for the user.
     */
    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
                    ->withPivot('acquired_at')
                    ->withTimestamps();
    }

    /**
     * Get the paid services offered by the user.
     */
    public function paidServices()
    {
        return $this->hasMany(PaidService::class, 'practitioner_id');
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin()
    {
        return $this->user_type === 'admin';
    }

    /**
     * Check if the user is a practitioner.
     */
    public function isPractitioner()
    {
        return $this->user_type === 'practitioner' || $this->user_type === 'expert';
    }

    /**
     * Check if the user is an expert practitioner.
     */
    public function isExpert()
    {
        return $this->user_type === 'expert';
    }

    /**
     * Check if the user is a client.
     */
    public function isClient()
    {
        return $this->user_type === 'client';
    }
}
