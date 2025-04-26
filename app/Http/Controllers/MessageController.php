<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Models\Consultation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the messages for a consultation.
     */
    public function index(Consultation $consultation)
    {
        $this->authorize('view', $consultation);

        // 鑑定のステータスが適切か確認
        if (!in_array($consultation->status, ['accepted', 'in_progress', 'completed'])) {
            return redirect()->route('consultations.show', $consultation)
                ->with('error', '鑑定が進行中でないため、メッセージを表示できません。');
        }

        // 鑑定に関連するメッセージを取得（古い順）
        $messages = $consultation->messages()
            ->with('sender')
            ->orderBy('created_at')
            ->get();

        // 自分宛のメッセージを既読にする
        $unreadMessages = $messages->where('receiver_id', Auth::id())->where('read_at', null);
        foreach ($unreadMessages as $message) {
            $message->markAsRead();
        }

        // 相手のユーザー情報を取得
        $user = Auth::user();
        $otherUser = $user->id === $consultation->client_id
            ? $consultation->practitioner
            : $consultation->client;

        return view('consultations.messages.index', [
            'consultation' => $consultation,
            'messages' => $messages,
            'otherUser' => $otherUser,
        ]);
    }

    /**
     * Store a newly created message in storage.
     */
    public function store(StoreMessageRequest $request, Consultation $consultation)
    {
        $this->authorize('create', [Message::class, $consultation]);

        // 鑑定のステータスが適切か確認
        if (!in_array($consultation->status, ['accepted', 'in_progress'])) {
            return redirect()->route('consultations.show', $consultation)
                ->with('error', '鑑定が進行中でないため、メッセージを送信できません。');
        }

        $user = Auth::user();

        // 受信者を特定
        $receiverId = $user->id === $consultation->client_id
            ? $consultation->practitioner_id
            : $consultation->client_id;

        // メッセージを作成
        $message = new Message([
            'consultation_id' => $consultation->id,
            'sender_id' => $user->id,
            'receiver_id' => $receiverId,
            'body' => $request->body,
        ]);

        $message->save();

        // 鑑定のステータスが 'accepted' の場合、'in_progress' に更新
        if ($consultation->status === 'accepted') {
            $consultation->update(['status' => 'in_progress']);
        }

        return redirect()->route('messages.index', $consultation)
            ->with('success', 'メッセージが送信されました。');
    }
}
