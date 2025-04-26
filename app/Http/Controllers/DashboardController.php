<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the dashboard based on user type.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } elseif ($user->isPractitioner()) {
            return $this->practitionerDashboard();
        } else {
            return $this->clientDashboard();
        }
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    private function adminDashboard()
    {
        $totalUsers = \App\Models\User::count();
        $totalConsultations = \App\Models\Consultation::count();
        $pendingConsultations = \App\Models\Consultation::where('status', 'pending')->count();
        $completedConsultations = \App\Models\Consultation::where('status', 'completed')->count();

        return view('dashboard.admin', compact(
            'totalUsers',
            'totalConsultations',
            'pendingConsultations',
            'completedConsultations'
        ));
    }

    /**
     * Show the practitioner dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    private function practitionerDashboard()
    {
        $user = auth()->user();

        $pendingConsultations = $user->practitionerConsultations()
            ->where('status', 'pending')
            ->with('client')
            ->latest()
            ->take(5)
            ->get();

        $activeConsultations = $user->practitionerConsultations()
            ->whereIn('status', ['accepted', 'in_progress'])
            ->with('client')
            ->latest()
            ->take(5)
            ->get();

        $completedConsultations = $user->practitionerConsultations()
            ->where('status', 'completed')
            ->with('client', 'review')
            ->latest()
            ->take(5)
            ->get();

        $totalReviews = $user->receivedReviews()->count();
        $averageRating = $user->receivedReviews()->avg('rating') ?? 0;
        $points = $user->points ? $user->points->balance : 0;
        $badges = $user->badges;

        return view('dashboard.practitioner', compact(
            'pendingConsultations',
            'activeConsultations',
            'completedConsultations',
            'totalReviews',
            'averageRating',
            'points',
            'badges'
        ));
    }

    /**
     * Show the client dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    private function clientDashboard()
    {
        $user = auth()->user();

        $activeConsultations = $user->clientConsultations()
            ->whereIn('status', ['pending', 'accepted', 'in_progress'])
            ->with('practitioner')
            ->latest()
            ->take(5)
            ->get();

        $completedConsultations = $user->clientConsultations()
            ->where('status', 'completed')
            ->with('practitioner', 'review')
            ->latest()
            ->take(5)
            ->get();

        $points = $user->points ? $user->points->balance : 0;

        // Get recommended practitioners
        $recommendedPractitioners = \App\Models\User::whereIn('user_type', ['practitioner', 'expert'])
            ->whereHas('profile', function ($query) {
                $query->where('is_available', true);
            })
            ->withCount(['receivedReviews as review_count'])
            ->withAvg(['receivedReviews as average_rating'], 'rating')
            ->orderByDesc('average_rating')
            ->orderByDesc('review_count')
            ->take(3)
            ->get();

        return view('dashboard.client', compact(
            'activeConsultations',
            'completedConsultations',
            'points',
            'recommendedPractitioners'
        ));
    }
}
