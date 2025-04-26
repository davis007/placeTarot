<?php

namespace Database\Seeders;

use App\Models\Consultation;
use App\Models\User;
use App\Models\Message;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ConsultationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = User::where('user_type', 'client')->get();
        $practitioners = User::whereIn('user_type', ['practitioner', 'expert'])->get();
        
        $statuses = ['pending', 'accepted', 'in_progress', 'completed', 'cancelled'];
        $titles = [
            '恋愛について相談したい',
            '仕事の転機について',
            '人間関係の悩み',
            '将来の方向性について',
            '結婚について迷っています',
            '転職すべきか悩んでいます',
            '人生の岐路に立っています',
            '金運について知りたい',
            '家族関係の改善について',
            '自己成長のためのアドバイス',
        ];
        
        $questions = [
            '最近、好きな人ができましたが、相手の気持ちがわかりません。どうアプローチすればいいでしょうか？',
            '今の仕事に行き詰まりを感じています。転職すべきか、このまま続けるべきか迷っています。',
            '職場の人間関係がうまくいかず、毎日ストレスを感じています。どう対処すればいいでしょうか？',
            '将来の方向性が見えず、何を目指して生きていけばいいのかわかりません。アドバイスをください。',
            '長く付き合っている恋人がいますが、結婚に踏み切れません。このまま関係を続けるべきでしょうか？',
            '今の会社で10年働いていますが、新しい挑戦をしたいという気持ちが強くなっています。転職のタイミングについてアドバイスください。',
            '人生の大きな決断を前にして迷っています。どの道を選ぶべきか、タロットで示唆をいただけますか？',
            '最近金運が落ちている気がします。金運を上げるためのアドバイスをいただけますか？',
            '親との関係がうまくいっていません。どうすれば関係を改善できるでしょうか？',
            '自分自身を成長させるために、今取り組むべきことは何でしょうか？',
        ];
        
        // 各クライアントに対して複数の鑑定を作成
        foreach ($clients as $client) {
            // 各鑑定師に対して1〜2件の鑑定を作成
            foreach ($practitioners as $practitioner) {
                $consultationCount = rand(1, 2);
                
                for ($i = 0; $i < $consultationCount; $i++) {
                    $status = $statuses[array_rand($statuses)];
                    $titleIndex = array_rand($titles);
                    $questionIndex = array_rand($questions);
                    
                    $createdAt = Carbon::now()->subDays(rand(1, 30));
                    $completedAt = null;
                    
                    if ($status === 'completed') {
                        $completedAt = Carbon::parse($createdAt)->addDays(rand(1, 7));
                    }
                    
                    $consultation = Consultation::create([
                        'client_id' => $client->id,
                        'practitioner_id' => $practitioner->id,
                        'title' => $titles[$titleIndex],
                        'question' => $questions[$questionIndex],
                        'status' => $status,
                        'is_paid' => in_array($status, ['accepted', 'in_progress', 'completed']),
                        'points_used' => in_array($status, ['accepted', 'in_progress', 'completed']) ? rand(10, 50) : 0,
                        'completed_at' => $completedAt,
                        'created_at' => $createdAt,
                        'updated_at' => $completedAt ?? $createdAt,
                    ]);
                    
                    // 承認済み以上のステータスの場合、メッセージを追加
                    if (in_array($status, ['accepted', 'in_progress', 'completed'])) {
                        $this->createMessages($consultation, $client, $practitioner);
                    }
                }
            }
        }
    }
    
    /**
     * 鑑定にメッセージを追加
     */
    private function createMessages($consultation, $client, $practitioner)
    {
        $messageCount = rand(2, 10);
        $createdAt = Carbon::parse($consultation->created_at);
        
        $clientMessages = [
            'タロット占いをお願いします。',
            '最近悩んでいることがあり、アドバイスをいただきたいです。',
            'ありがとうございます。もう少し詳しく教えていただけますか？',
            'なるほど、理解できました。他に気をつけることはありますか？',
            'アドバイスを実践してみます。ありがとうございました。',
        ];
        
        $practitionerMessages = [
            'ご相談ありがとうございます。タロットを引いてみますね。',
            'カードからは、あなたが今転機を迎えていることが示されています。',
            '「正義」のカードが出ました。バランスを取ることが大切なようです。',
            '「恋人」のカードは、選択の時が来ていることを示しています。',
            '「太陽」のカードは、明るい未来が待っていることを示唆しています。',
            'もう少し具体的な状況を教えていただけますか？',
            'あなたの直感を信じることが大切です。',
            '今は行動するよりも、内省の時間を持つことをお勧めします。',
            '新しい出会いが近いうちにあるでしょう。',
            '過去の経験から学び、前に進む時が来ています。',
        ];
        
        for ($i = 0; $i < $messageCount; $i++) {
            $isSenderClient = $i % 2 === 0;
            $sender = $isSenderClient ? $client : $practitioner;
            $receiver = $isSenderClient ? $practitioner : $client;
            $messageArray = $isSenderClient ? $clientMessages : $practitionerMessages;
            
            $messageText = $messageArray[array_rand($messageArray)];
            $messageCreatedAt = $createdAt->copy()->addHours($i + 1);
            
            // 最後のメッセージの場合は、完了日より前にする
            if ($consultation->completed_at && $messageCreatedAt > $consultation->completed_at) {
                $messageCreatedAt = Carbon::parse($consultation->completed_at)->subHours(1);
            }
            
            Message::create([
                'consultation_id' => $consultation->id,
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'body' => $messageText,
                'read_at' => $isSenderClient ? $messageCreatedAt->copy()->addMinutes(rand(5, 60)) : null,
                'created_at' => $messageCreatedAt,
                'updated_at' => $messageCreatedAt,
            ]);
        }
    }
}
