<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tokens_check', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users', 'id')->cascadeOnDelete();

            $table->string('token_to');
            $table->string('token', 60);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_token_check');
    }
};
