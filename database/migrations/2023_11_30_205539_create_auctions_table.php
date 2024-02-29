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
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->json('info');
            $table->text('about');
            $table->text('description');
            $table->integer('price');
            $table->integer('minimum_bid');
            $table->timestamp('end');
            $table->foreignId('user_id');
            $table->foreignId('winner_id')->nullable();
            $table->boolean('buy_now')->default(false);
            $table->integer('buy_now_price')->nullable();
            $table->string('winner_code')->nullable();
            $table->boolean('approved')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};
