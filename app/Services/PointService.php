<?php

namespace App\Services;

use App\Models\Point;
use App\Models\PointTransaction;
use App\Models\User;
use App\Models\Badge;
use App\Models\UserBadge;
use Illuminate\Support\Facades\DB;

class PointService
{
    /**
     * Add points to a user.
     *
     * @param int $userId
     * @param int $amount
     * @param string $type
     * @param string $description
     * @param int|null $referenceId
     * @param string|null $referenceType
     * @return \App\Models\PointTransaction
     */
    public function addPoints(int $userId, int $amount, string $type, string $description, $referenceId = null, $referenceType = null)
    {
        DB::transaction(function () use ($userId, $amount, $type, $description, $referenceId, $referenceType, &$transaction) {
            // Get user's points
            $points = Point::where('user_id', $userId)->firstOrFail();
            
            // Update balance
            $points->update([
                'balance' => $points->balance + $amount,
            ]);
            
            // Create transaction record
            $transaction = PointTransaction::create([
                'user_id' => $userId,
                'amount' => $amount,
                'type' => $type,
                'description' => $description,
                'reference_id' => $referenceId,
                'reference_type' => $referenceType,
            ]);
            
            // Check if user qualifies for any badges
            $this->checkAndAssignBadges($userId);
        });
        
        return $transaction;
    }
    
    /**
     * Deduct points from a user.
     *
     * @param int $userId
     * @param int $amount
     * @param string $type
     * @param string $description
     * @param int|null $referenceId
     * @param string|null $referenceType
     * @return \App\Models\PointTransaction
     * @throws \Exception
     */
    public function deductPoints(int $userId, int $amount, string $type, string $description, $referenceId = null, $referenceType = null)
    {
        DB::transaction(function () use ($userId, $amount, $type, $description, $referenceId, $referenceType, &$transaction) {
            // Get user's points
            $points = Point::where('user_id', $userId)->firstOrFail();
            
            // Check if user has enough points
            if ($points->balance < $amount) {
                throw new \Exception('ポイントが不足しています。');
            }
            
            // Update balance
            $points->update([
                'balance' => $points->balance - $amount,
            ]);
            
            // Create transaction record
            $transaction = PointTransaction::create([
                'user_id' => $userId,
                'amount' => -$amount,
                'type' => $type,
                'description' => $description,
                'reference_id' => $referenceId,
                'reference_type' => $referenceType,
            ]);
        });
        
        return $transaction;
    }
    
    /**
     * Purchase points.
     *
     * @param int $userId
     * @param int $amount
     * @return \App\Models\PointTransaction
     */
    public function purchasePoints(int $userId, int $amount)
    {
        return $this->addPoints($userId, $amount, 'purchase', 'ポイント購入');
    }
    
    /**
     * Get point transactions for a user.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserTransactions(int $userId)
    {
        return PointTransaction::where('user_id', $userId)
            ->latest()
            ->get();
    }
    
    /**
     * Check if user qualifies for any badges and assign them.
     *
     * @param int $userId
     * @return void
     */
    private function checkAndAssignBadges(int $userId)
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
