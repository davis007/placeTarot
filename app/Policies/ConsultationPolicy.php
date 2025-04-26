<?php

namespace App\Policies;

use App\Models\Consultation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ConsultationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Any authenticated user can view their consultations
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Consultation $consultation): bool
    {
        // Only the client or practitioner involved in the consultation can view it
        return $user->id === $consultation->client_id || 
               $user->id === $consultation->practitioner_id ||
               $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isClient(); // Only clients can create consultations
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Consultation $consultation): bool
    {
        // Only the practitioner assigned to this consultation can update it
        return $user->id === $consultation->practitioner_id;
    }

    /**
     * Determine whether the user can update the status of the model.
     */
    public function updateStatus(User $user, Consultation $consultation): bool
    {
        // Only the practitioner assigned to this consultation can update its status
        return $user->id === $consultation->practitioner_id;
    }

    /**
     * Determine whether the user can cancel the consultation.
     */
    public function cancel(User $user, Consultation $consultation): bool
    {
        // Only the client who created the consultation can cancel it
        // And only if it's in pending or accepted status
        return $user->id === $consultation->client_id && 
               in_array($consultation->status, ['pending', 'accepted']);
    }
}
