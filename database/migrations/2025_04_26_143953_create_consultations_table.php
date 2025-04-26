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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('practitioner_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('question');
            $table->enum('status', ['pending', 'accepted', 'rejected', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->boolean('is_paid')->default(false);
            $table->integer('points_used')->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
