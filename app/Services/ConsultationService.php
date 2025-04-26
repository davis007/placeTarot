<?php

namespace App\Services;

use App\Models\Consultation;
use App\Models\User;
use App\Models\PointTransaction;
use Illuminate\Support\Facades\DB;

class ConsultationService
{
    /**
     * Create a new consultation.
     *
     * @param array $data
     * @param int $clientId
     * @return \App\Models\Consultation
     */
    public function createConsultation(array $data, int $clientId)
    {
        return Consultation::create([
            'client_id' => $clientId,
            'practitioner_id' => $data['practitioner_id'],
            'title' => $data['title'],
            'question' => $data['question'],
            'status' => 'pending',
            'is_paid' => false,
            'points_used' => 0,
        ]);
    }

    /**
     * Accept a consultation.
     *
     * @param \App\Models\Consultation $consultation
     * @return \App\Models\Consultation
     */
    public function acceptConsultation(Consultation $consultation)
    {
        $consultation->update([
            'status' => 'accepted',
        ]);

        return $consultation;
    }

    /**
     * Complete a consultation.
     *
     * @param \App\Models\Consultation $consultation
     * @return \App\Models\Consultation
     */
    public function completeConsultation(Consultation $consultation)
    {
        $consultation->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return $consultation;
    }

    /**
     * Reject a consultation.
     *
     * @param \App\Models\Consultation $consultation
     * @return \App\Models\Consultation
     */
    public function rejectConsultation(Consultation $consultation)
    {
        $consultation->update([
            'status' => 'rejected',
        ]);

        return $consultation;
    }

    /**
     * Cancel a consultation.
     *
     * @param \App\Models\Consultation $consultation
     * @return \App\Models\Consultation
     */
    public function cancelConsultation(Consultation $consultation)
    {
        $consultation->update([
            'status' => 'cancelled',
        ]);

        return $consultation;
    }

    /**
     * Create a paid consultation.
     *
     * @param array $data
     * @param int $clientId
     * @param int $points
     * @return \App\Models\Consultation
     */
    public function createPaidConsultation(array $data, int $clientId, int $points)
    {
        DB::transaction(function () use ($data, $clientId, $points, &$consultation) {
            // Create consultation
            $consultation = Consultation::create([
                'client_id' => $clientId,
                'practitioner_id' => $data['practitioner_id'],
                'title' => $data['title'],
                'question' => $data['question'],
                'status' => 'pending',
                'is_paid' => true,
                'points_used' => $points,
            ]);

            // Deduct points from client
            $client = User::findOrFail($clientId);
            $client->points->update([
                'balance' => $client->points->balance - $points,
            ]);

            // Record transaction
            PointTransaction::create([
                'user_id' => $clientId,
                'amount' => -$points,
                'type' => 'consumption',
                'description' => '有料鑑定の依頼',
                'reference_id' => $consultation->id,
                'reference_type' => Consultation::class,
            ]);
        });

        return $consultation;
    }

    /**
     * Get consultations for a client.
     *
     * @param int $clientId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getClientConsultations(int $clientId)
    {
        return Consultation::where('client_id', $clientId)
            ->with(['practitioner', 'messages'])
            ->latest()
            ->get();
    }

    /**
     * Get consultations for a practitioner.
     *
     * @param int $practitionerId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPractitionerConsultations(int $practitionerId)
    {
        return Consultation::where('practitioner_id', $practitionerId)
            ->with(['client', 'messages'])
            ->latest()
            ->get();
    }

    /**
     * Get available practitioners.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAvailablePractitioners()
    {
        return User::whereIn('user_type', ['practitioner', 'expert'])
            ->whereHas('profile', function ($query) {
                $query->where('is_available', true);
            })
            ->with('profile')
            ->get();
    }
}
