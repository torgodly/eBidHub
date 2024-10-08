<?php

namespace App\Filament\Widgets;

use App\Models\Auction;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class AdminChartOverview extends ChartWidget
{
    protected static ?string $heading = 'Chart';
    protected static ?int $sort = 1;


    protected function getData(): array
    {
        $data = Trend::model(Auction::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Auctions',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
