<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\Point;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 管理者
        $admin = User::create([
            'name' => '管理者',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'user_type' => 'admin',
        ]);

        Profile::create([
            'user_id' => $admin->id,
            'bio' => 'システム管理者です。',
        ]);

        Point::create([
            'user_id' => $admin->id,
            'balance' => 1000,
        ]);

        // 鑑定師（一般）
        $practitioners = [
            [
                'name' => '山田太郎',
                'email' => 'yamada@example.com',
                'bio' => '10年間タロット占いを行っています。恋愛相談が得意です。丁寧な鑑定を心がけています。',
                'specialties' => ['恋愛', '人間関係', '仕事'],
                'response_time' => '通常24時間以内',
            ],
            [
                'name' => '佐藤花子',
                'email' => 'sato@example.com',
                'bio' => '西洋占星術とタロットを組み合わせた鑑定を行っています。未来の可能性を一緒に探りましょう。',
                'specialties' => ['恋愛', '結婚', '転職'],
                'response_time' => '通常12時間以内',
            ],
            [
                'name' => '鈴木一郎',
                'email' => 'suzuki@example.com',
                'bio' => '仕事や転職に関する相談が得意です。タロットと数秘術を組み合わせた鑑定を行います。',
                'specialties' => ['仕事', 'キャリア', '金運'],
                'response_time' => '通常48時間以内',
            ],
        ];

        foreach ($practitioners as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'user_type' => 'practitioner',
            ]);

            Profile::create([
                'user_id' => $user->id,
                'bio' => $data['bio'],
                'specialties' => $data['specialties'],
                'response_time' => $data['response_time'],
                'is_available' => true,
            ]);

            Point::create([
                'user_id' => $user->id,
                'balance' => rand(100, 500),
            ]);
        }

        // 優良鑑定師
        $experts = [
            [
                'name' => '高橋道子',
                'email' => 'takahashi@example.com',
                'bio' => '20年以上の鑑定経験があります。タロット、西洋占星術、四柱推命など複数の占術を使い分けて鑑定します。特に人生の転機における選択のアドバイスが得意です。',
                'specialties' => ['人生相談', '転機', '恋愛', '結婚'],
                'response_time' => '通常6時間以内',
            ],
            [
                'name' => '田中誠',
                'email' => 'tanaka@example.com',
                'bio' => 'タロット歴15年。心理カウンセラーの資格も持っています。心の悩みや人間関係の問題解決をサポートします。',
                'specialties' => ['メンタルヘルス', '人間関係', '自己啓発'],
                'response_time' => '通常12時間以内',
            ],
        ];

        foreach ($experts as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'user_type' => 'expert',
            ]);

            Profile::create([
                'user_id' => $user->id,
                'bio' => $data['bio'],
                'specialties' => $data['specialties'],
                'response_time' => $data['response_time'],
                'is_available' => true,
            ]);

            Point::create([
                'user_id' => $user->id,
                'balance' => rand(500, 1000),
            ]);
        }

        // 相談者
        $clients = [
            [
                'name' => '伊藤裕子',
                'email' => 'ito@example.com',
                'bio' => '初めてタロット占いを受けます。恋愛について相談したいです。',
            ],
            [
                'name' => '中村健太',
                'email' => 'nakamura@example.com',
                'bio' => '仕事の転機について悩んでいます。アドバイスをいただけると嬉しいです。',
            ],
            [
                'name' => '小林美咲',
                'email' => 'kobayashi@example.com',
                'bio' => '人間関係で悩んでいます。良い解決策を見つけたいです。',
            ],
            [
                'name' => '加藤大輔',
                'email' => 'kato@example.com',
                'bio' => '将来の方向性について迷っています。',
            ],
        ];

        foreach ($clients as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'user_type' => 'client',
            ]);

            Profile::create([
                'user_id' => $user->id,
                'bio' => $data['bio'],
            ]);

            Point::create([
                'user_id' => $user->id,
                'balance' => rand(50, 200),
            ]);
        }
    }
}
