<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        \App\Models\User::factory(20)->create();
//        Auction::factory(1)->create()->each(function (Auction $auction) {
//            for ($i = 0; $i < 5; $i++) {
//                $auction->addMediaFromUrl('https://picsum.photos/1024/683')->toMediaCollection('Auctions');
//            }
//        });
////        Bid::factory(50)->create();
//        \App\Models\Comment::factory(50)->create();
//        Category::factory(100)->create();
//

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@admin.com',
            'type' => 'admin',
            'balance' => 100000,
        ]);
    }
}
