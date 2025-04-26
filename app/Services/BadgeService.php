<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\User;
use App\Models\UserBadge;
use App\Models\PointTransaction;

class BadgeService
{
    /**
     * Create a new badge.
     *
     * @param array $data
     * @return \App\Models\Badge
     */
    public function createBadge(array $data)
    {
        return Badge::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'required_points' => $data['required_points'],
            'icon' => $data['icon'],
        ]);
    }

    /**
     * Update a badge.
     *
     * @param \App\Models\Badge $badge
     * @param array $data
     * @return \App\Models\Badge
     */
    public function updateBadge(Badge $badge, array $data)
    {
        $badge->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'required_points' => $data['required_points'],
            'icon' => $data['icon'],
        ]);

        return $badge;
    }

    /**
     * Delete a badge.
     *
     * @param \App\Models\Badge $badge
     * @return bool|null
     */
    public function deleteBadge(Badge $badge)
    {
        return $badge->delete();
    }

    /**
     * Get all badges.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllBadges()
    {
        return Badge::orderBy('required_points')->get();
    }

    /**
     * Get badges for a user.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserBadges(int $userId)
    {
        return Badge::whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();
    }

    /**
     * Check and assign badges to a user.
     *
     * @param int $userId
     * @return void
     */
    public function checkAndAssignBadges(int $userId)
    {
        $user = User::findOrFail($userId);
        
        // Only check for practitioners
        if (!$user->isPractitioner()) {
            return;
        }
        
        // Get total earned points
        $totalPoints = PointTransaction::where('user_id', $userId)
            ->where('amount', '>', 0)
            ->sum('amount');
        
        // Get badges that user qualifies for but doesn't have yet
        $badges = Badge::where('required_points', '<=', $totalPoints)
            ->whereDoesntHave('users', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->get();
        
        foreach ($badges as $badge) {
            // Assign badge to user
            UserBadge::create([
                'user_id' => $userId,
                'badge_id' => $badge->id,
                'acquired_at' => now(),
            ]);
            
            // If this is the expert badge, update user type
            if ($badge->required_points >= 5000 && $user->user_type === 'practitioner') {
                $user->update([
                    'user_type' => 'expert',
                ]);
            }
        }
    }
}
