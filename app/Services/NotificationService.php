<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ConsultationRequested;
use App\Notifications\ConsultationAccepted;
use App\Notifications\ConsultationCompleted;
use App\Notifications\NewMessage;
use App\Notifications\ReviewReceived;
use App\Notifications\BadgeEarned;

class NotificationService
{
    /**
     * Send consultation requested notification.
     *
     * @param \App\Models\Consultation $consultation
     * @return void
     */
    public function sendConsultationRequestedNotification($consultation)
    {
        $practitioner = User::findOrFail($consultation->practitioner_id);
        $practitioner->notify(new ConsultationRequested($consultation));
    }

    /**
     * Send consultation accepted notification.
     *
     * @param \App\Models\Consultation $consultation
     * @return void
     */
    public function sendConsultationAcceptedNotification($consultation)
    {
        $client = User::findOrFail($consultation->client_id);
        $client->notify(new ConsultationAccepted($consultation));
    }

    /**
     * Send consultation completed notification.
     *
     * @param \App\Models\Consultation $consultation
     * @return void
     */
    public function sendConsultationCompletedNotification($consultation)
    {
        $client = User::findOrFail($consultation->client_id);
        $client->notify(new ConsultationCompleted($consultation));
    }

    /**
     * Send new message notification.
     *
     * @param \App\Models\Message $message
     * @return void
     */
    public function sendNewMessageNotification($message)
    {
        $consultation = $message->consultation;
        $sender = User::findOrFail($message->sender_id);
        
        // Determine recipient
        $recipientId = ($sender->id === $consultation->client_id) 
            ? $consultation->practitioner_id 
            : $consultation->client_id;
            
        $recipient = User::findOrFail($recipientId);
        $recipient->notify(new NewMessage($message));
    }

    /**
     * Send review received notification.
     *
     * @param \App\Models\Review $review
     * @return void
     */
    public function sendReviewReceivedNotification($review)
    {
        $practitioner = User::findOrFail($review->practitioner_id);
        $practitioner->notify(new ReviewReceived($review));
    }

    /**
     * Send badge earned notification.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Badge $badge
     * @return void
     */
    public function sendBadgeEarnedNotification($user, $badge)
    {
        $user->notify(new BadgeEarned($badge));
    }
}
