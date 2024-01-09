<?php

namespace App\Filament\Widgets;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\Comment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends BaseWidget
{

    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $totalBidsCount = Bid::count();
        $totalComments = Comment::count();
        $totalAuctions = Auction::count();
        
        $activityRate = ($totalBidsCount + $totalComments) / max(1, $totalAuctions);


        return [
            Stat::make('Bidder Engagement', $totalBidsCount)
                ->description('Average bids per day')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->chart([4.0, 4.5, 4.2, 4.8, 5.0])
                ->color('info'),

            Stat::make('Activity Rate', $activityRate)
                ->description('Overall activity rate')
                ->descriptionIcon('heroicon-m-information-circle')
                ->chart([3.0, 3.5, 3.2, 3.8, 4.0])
                ->color('info'),
        ];
    }
}
