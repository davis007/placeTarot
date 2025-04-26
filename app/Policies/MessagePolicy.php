<?php

namespace App\Policies;

use App\Models\Consultation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MessagePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // 認証済みユーザーは自分のメッセージを閲覧可能
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Message $message): bool
    {
        // メッセージの送信者または受信者のみが閲覧可能
        return $user->id === $message->sender_id || $user->id === $message->receiver_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @param Consultation $consultation 鑑定
     */
    public function create(User $user, Consultation $consultation): bool
    {
        // 鑑定の参加者（相談者または担当鑑定師）のみがメッセージを作成可能
        return $user->id === $consultation->client_id ||
               $user->id === $consultation->practitioner_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Message $message): bool
    {
        // メッセージの更新は不可
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Message $message): bool
    {
        // メッセージの削除は不可
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Message $message): bool
    {
        // メッセージの復元は不可
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Message $message): bool
    {
        // メッセージの完全削除は不可
        return false;
    }
}
