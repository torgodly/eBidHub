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
            $table->string('about');
            $table->text('description');
            $table->integer('price');
            //minium bid
            $table->integer('minimum_bid');
            $table->timestamp('end');
            $table->foreignId('user_id');
            $table->foreignId('winner_id')->nullable();
            $table->boolean('buy_now')->default(false);
            $table->string('winner_code')->nullable();
            $table->boolean('approved')->default(false);
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
