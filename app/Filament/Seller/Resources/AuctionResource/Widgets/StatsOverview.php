<?php

namespace App\Filament\Seller\Resources\AuctionResource\Widgets;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\Comment;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class StatsOverview extends BaseWidget
{

    protected function getStats(): array
    {
        // Total Bids Count
        $totalBidsCount = Bid::count();

        // Total Auctions Count
        $totalAuctions = Auction::count();

        // Total Comments Count
        $totalComments = Comment::count();

        // Calculate Activity Rate
        $activityRate = ($totalBidsCount + $totalComments) / max(1, $totalAuctions);

        // Calculate Total Revenue Generated
        $totalRevenueGenerated = Auction::whereNotNull('winner_id')->get()->sum('end_price');

        // Calculate Ending Soon Alerts
        $endingSoonAlerts = Auction::where('end', '>', now())
            ->where('end', '<', now()->addHours(3))
            ->count();

        // Calculate User Participation
        $userParticipation = Auction::distinct('user_id')->count();

        // Calculate Bidder Engagement
        $totalBids = Bid::count();
        $totalDays = max(1, Carbon::now()->diffInDays(Auction::min('created_at')));
        $bidderEngagement = $totalBids / $totalDays;

        // Get Top Bidders
        $topBidders = Bid::with('user')->selectRaw('user_id, sum(amount) as total_amount')
            ->groupBy('user_id')
            ->orderByDesc('total_amount')
            ->first();
//        dd($topBidders);

        // Example data for charts
        $bidsCountChartData = Bid::selectRaw('DATE(created_at) as date, count(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count')
            ->toArray();

        return [
            Stat::make(__('Bids Count'), $totalBidsCount)
                ->description(__('Total bids across all auctions'))
                ->descriptionIcon('heroicon-m-information-circle')
                ->chart($bidsCountChartData)
                ->color('primary'),

            Stat::make(__('Activity Rate'), $activityRate)
                ->description(__('Overall activity rate'))
                ->descriptionIcon('heroicon-m-information-circle')
                ->chart([3.0, 3.5, 3.2, 3.8, 4.0])
                ->color('info'),

            Stat::make(__('Revenue Generated'), '$' . Number::format($totalRevenueGenerated))
                ->description(__('Total revenue generated'))
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->chart([1000, 2000, 3000, 4000, 5000])
                ->color('success'),

            Stat::make(__('Ending Soon Alerts'), $endingSoonAlerts)
                ->description(__('Auctions ending soon'))
                ->descriptionIcon('heroicon-m-clock')
                ->chart([5, 6, 7, 4, 5])
                ->color('warning'),

            Stat::make(__('User Participation'), $userParticipation)
                ->description(__('Total users participating'))
                ->descriptionIcon('heroicon-m-users')
                ->chart([1200, 1300, 1400, 1500, 1600])
                ->color('primary'),

            Stat::make(__('Bidder Engagement'), $bidderEngagement)
                ->description(__('Average bids per day'))
                ->descriptionIcon('heroicon-m-chart-bar')
                ->chart([4.0, 4.5, 4.2, 4.8, 5.0])
                ->color('info'),

            Stat::make(__('Top Bidders'), $topBidders->user?->name ?? '-' . ' - $' . Number::format($topBidders->total_amount ?? 0))
                ->description(__('Top bidders and total amounts'))
                ->descriptionIcon('heroicon-m-trophy')
                ->color('warning')->extraAttributes(['style' => 'width: max-content;']),
        ];
    }
}








// app/Filament/Seller/Resources/AuctionResource/Widgets/SystemStats.php
