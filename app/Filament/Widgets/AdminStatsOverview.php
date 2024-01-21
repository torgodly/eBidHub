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
        $userCount = \App\Models\User::count();

        $activityRate = ($totalBidsCount + $totalComments) / max(1, $totalAuctions);


        return [
            Stat::make(__('Bidder Engagement'), $totalBidsCount)
                ->description(__("Total bids"))
                ->descriptionIcon('heroicon-m-chart-bar')
                ->chart([4.0, 4.5, 4.2, 4.8, 5.0])
                ->color('info'),

            Stat::make(__("Activity Rate"), $activityRate)
                ->description(__("Overall activity rate"))
                ->descriptionIcon('heroicon-m-information-circle')
                ->chart([3.0, 3.5, 3.2, 3.8, 4.0])
                ->color('info'),

             Stat::make(__("Users Count"), $userCount)
                 ->description(__("Total users"))
                 ->descriptionIcon('heroicon-m-user-group')
                 ->chart([3.0, 3.5, 3.2, 3.8, 4.0])
                 ->color('info'),
        ];
    }
}
