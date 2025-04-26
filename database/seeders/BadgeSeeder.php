<?php

namespace Database\Seeders;

use App\Models\Badge;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // バッジの作成
        $badges = [
            [
                'name' => '新人鑑定師',
                'description' => '鑑定師としての第一歩を踏み出しました。',
                'required_points' => 0,
                'icon' => 'star_outline',
            ],
            [
                'name' => '人気鑑定師',
                'description' => '10件以上の鑑定を完了しました。',
                'required_points' => 100,
                'icon' => 'star_half',
            ],
            [
                'name' => '熟練鑑定師',
                'description' => '50件以上の鑑定を完了し、高い評価を得ています。',
                'required_points' => 500,
                'icon' => 'star',
            ],
            [
                'name' => '信頼の鑑定師',
                'description' => '100件以上の鑑定を完了し、非常に高い評価を維持しています。',
                'required_points' => 1000,
                'icon' => 'stars',
            ],
            [
                'name' => '迅速対応',
                'description' => '素早い返信で相談者をサポートしています。',
                'required_points' => 200,
                'icon' => 'bolt',
            ],
            [
                'name' => '的確アドバイザー',
                'description' => '的確なアドバイスで多くの相談者から高評価を得ています。',
                'required_points' => 300,
                'icon' => 'psychology',
            ],
        ];
        
        foreach ($badges as $data) {
            Badge::create($data);
        }
        
        // 鑑定師にバッジを付与
        $practitioners = User::whereIn('user_type', ['practitioner', 'expert'])->get();
        $allBadges = Badge::all();
        
        foreach ($practitioners as $practitioner) {
            // 新人鑑定師バッジは全員に付与
            $practitioner->badges()->attach(1, [
                'acquired_at' => Carbon::now()->subDays(rand(30, 90)),
            ]);
            
            // 他のバッジはランダムに付与
            $badgeCount = $practitioner->user_type === 'expert' ? rand(2, 5) : rand(1, 3);
            $badgeIds = $allBadges->where('id', '>', 1)->random($badgeCount)->pluck('id');
            
            foreach ($badgeIds as $badgeId) {
                $practitioner->badges()->attach($badgeId, [
                    'acquired_at' => Carbon::now()->subDays(rand(1, 30)),
                ]);
            }
        }
    }
}
