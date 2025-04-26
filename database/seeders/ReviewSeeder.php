<?php

namespace Database\Seeders;

use App\Models\Consultation;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 完了した鑑定に対してレビューを作成
        $completedConsultations = Consultation::where('status', 'completed')->get();
        
        $comments = [
            '丁寧な鑑定をありがとうございました。アドバイスが的確で参考になりました。',
            '優しい言葉で背中を押してもらえました。また相談したいです。',
            '悩みが解決しました。ありがとうございます！',
            '鑑定結果に納得できました。これからの方向性が見えてきました。',
            'とても分かりやすい説明でした。心が軽くなりました。',
            '親身になって相談に乗ってくれて感謝しています。',
            '的確なアドバイスをいただき、行動に移す勇気が出ました。',
            '鑑定師さんの温かい人柄が伝わってきました。安心して相談できました。',
            '予想以上に詳しい鑑定で満足しています。',
            'アドバイスを実践したところ、状況が好転しました！',
        ];
        
        foreach ($completedConsultations as $consultation) {
            // 80%の確率でレビューを作成
            if (rand(1, 100) <= 80) {
                $rating = rand(3, 5); // 3〜5の評価
                $commentIndex = array_rand($comments);
                $createdAt = Carbon::parse($consultation->completed_at)->addDays(rand(1, 3));
                
                Review::create([
                    'consultation_id' => $consultation->id,
                    'client_id' => $consultation->client_id,
                    'practitioner_id' => $consultation->practitioner_id,
                    'rating' => $rating,
                    'comment' => $comments[$commentIndex],
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }
        }
    }
}
