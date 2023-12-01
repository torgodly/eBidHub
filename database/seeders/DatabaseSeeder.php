<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Auction;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        Auction::factory(20)->create()->each(function (Auction $auction) {
            $auction->addMediaFromUrl('https://picsum.photos/1024/683')->toMediaCollection('Auctions');
        });

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@admin.com',
        ]);
    }
}
