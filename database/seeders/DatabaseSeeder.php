<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Auction;
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
        $categories = [
            "سيارات",
            "مجوهرات",
            "الساعات",
            "أجهزة إلكترونية",
            "معدات صناعية",
            "الفنون والتحف",
            "الأدوات التقليدية",
            "الملابس والأزياء",
            "الأثاث المنزلي",
            "أدوات الطهي",
            "الكتب والمطبوعات",
            "الألعاب والترفيه",
            "الأدوات الرياضية",
            "الأجهزة الطبية",
            "مستلزمات الحيوانات الأليفة",
            "المواد الغذائية",
            "مستحضرات التجميل",
            "المنتجات الصحية",
            "الأثاث المكتبي",
            "معدات الرياضة واللياقة البدنية"
        ];
        foreach ($categories as $category) {
            Category::factory()->create([
                'name' => $category,
            ]);
        }
        Auction::factory(100)->create()->each(function (Auction $auction) {
            for ($i = 0; $i < 5; $i++) {
                $auction->addMediaFromUrl('https://picsum.photos/1024/683')->toMediaCollection('Auctions');
            }
            $auction->categories()->attach(Category::inRandomOrder()->limit(5)->get());
        });
////        Bid::factory(50)->create();
//        \App\Models\Comment::factory(50)->create();
//

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@admin.com',
            'type' => 'admin',
            'balance' => 100000,
        ]);
        \App\Models\User::factory()->create([
            'name' => 'User User',
            'email' => 'torgodly@gmail.com',
            'type' => 'user',
            'balance' => 100000,
        ]);
    }
}
