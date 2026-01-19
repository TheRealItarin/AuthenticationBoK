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
        Schema::create('text_entries', function (Blueprint $table) {
            $table->id();
            $table->longText('text');  // Individual text entry
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');  // Who wrote it
            $table->timestamps();  // created_at (when it was written)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('text_entries');
    }
};
