<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // content カラムを body に変更
            $table->renameColumn('content', 'body');

            // is_read ブール値を read_at タイムスタンプに変更
            $table->dropColumn('is_read');
            $table->timestamp('read_at')->nullable();

            // receiver_id カラムを追加
            $table->foreignId('receiver_id')->after('sender_id')->constrained('users')->onDelete('cascade');

            // インデックスを追加
            $table->index('receiver_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // read_at タイムスタンプを is_read ブール値に戻す
            $table->dropColumn('read_at');
            $table->boolean('is_read')->default(false);

            // body カラムを content に戻す
            $table->renameColumn('body', 'content');

            // receiver_id カラムを削除
            $table->dropForeign(['receiver_id']);
            $table->dropIndex(['receiver_id']);
            $table->dropColumn('receiver_id');
        });
    }
};
