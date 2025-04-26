<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConsultationRequest;
use App\Http\Requests\UpdateConsultationStatusRequest;
use App\Models\Consultation;
use App\Models\Message;
use App\Models\User;
use App\Services\ConsultationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    protected $consultationService;

    /**
     * Create a new controller instance.
     */
    public function __construct(ConsultationService $consultationService)
    {
        $this->consultationService = $consultationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isClient()) {
            // For clients, show their consultation requests
            $consultations = $user->clientConsultations()
                ->with('practitioner')
                ->latest()
                ->paginate(10);

            return view('consultations.client-index', compact('consultations'));
        } else {
            // For practitioners, show consultations where they are the practitioner
            $consultations = $user->practitionerConsultations()
                ->with('client')
                ->latest()
                ->paginate(10);

            return view('consultations.practitioner-index', compact('consultations'));
        }
    }

    /**
     * Display a listing of practitioners.
     */
    public function practitioners()
    {
        $practitioners = User::where('user_type', 'practitioner')
            ->orWhere('user_type', 'expert')
            ->with('profile')
            ->paginate(12);

        return view('consultations.practitioners', compact('practitioners'));
    }

    /**
     * Display a practitioner's profile.
     */
    public function practitionerProfile(User $user)
    {
        if (!$user->isPractitioner()) {
            abort(404);
        }

        $reviews = $user->receivedReviews()
            ->with('client')
            ->latest()
            ->take(5)
            ->get();

        return view('consultations.practitioner-profile', [
            'practitioner' => $user,
            'profile' => $user->profile,
            'reviews' => $reviews,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(User $practitioner)
    {
        if (!$practitioner->isPractitioner()) {
            abort(404);
        }

        return view('consultations.create', [
            'practitioner' => $practitioner,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreConsultationRequest $request)
    {
        $this->authorize('create', Consultation::class);

        $consultation = $this->consultationService->createConsultation(
            $request->validated(),
            Auth::id()
        );

        return redirect()->route('consultations.index')
            ->with('success', '鑑定リクエストが送信されました。鑑定師からの返答をお待ちください。');
    }

    /**
     * Display the specified resource.
     */
    public function show(Consultation $consultation)
    {
        $this->authorize('view', $consultation);

        $consultation->load(['client', 'practitioner']);

        // メッセージ数を取得
        $messageCount = $consultation->messages()->count();

        // 未読メッセージ数を取得
        $unreadMessageCount = $consultation->messages()
            ->where('receiver_id', Auth::id())
            ->whereNull('read_at')
            ->count();

        return view('consultations.show', compact('consultation', 'messageCount', 'unreadMessageCount'));
    }

    /**
     * Display pending consultation requests for the practitioner.
     */
    public function pendingRequests()
    {
        $user = Auth::user();

        if (!$user->isPractitioner()) {
            abort(403, '鑑定師権限が必要です。');
        }

        $pendingConsultations = $user->practitionerConsultations()
            ->with('client')
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('consultations.pending-requests', compact('pendingConsultations'));
    }

    /**
     * Update the status of a consultation (accept/reject).
     */
    public function updateStatus(UpdateConsultationStatusRequest $request, Consultation $consultation)
    {
        $this->authorize('updateStatus', $consultation);

        $status = $request->status;

        if ($status === 'accepted') {
            $this->consultationService->acceptConsultation($consultation);
            $message = '鑑定リクエストを承認しました。';
        } else {
            $this->consultationService->rejectConsultation($consultation);
            $message = '鑑定リクエストを拒否しました。';
        }

        return redirect()->route('consultations.pending-requests')
            ->with('success', $message);
    }

    /**
     * Accept a consultation request.
     */
    public function accept(Consultation $consultation)
    {
        $this->authorize('updateStatus', $consultation);

        $this->consultationService->acceptConsultation($consultation);

        return redirect()->route('consultations.show', $consultation)
            ->with('success', '鑑定リクエストを承認しました。');
    }

    /**
     * Complete a consultation.
     */
    public function complete(Consultation $consultation)
    {
        $this->authorize('updateStatus', $consultation);

        $this->consultationService->completeConsultation($consultation);

        return redirect()->route('consultations.show', $consultation)
            ->with('success', '鑑定を完了しました。');
    }

    /**
     * Cancel a consultation.
     */
    public function cancel(Consultation $consultation)
    {
        $this->authorize('cancel', $consultation);

        $this->consultationService->cancelConsultation($consultation);

        return redirect()->route('consultations.index')
            ->with('success', '鑑定リクエストをキャンセルしました。');
    }
}
