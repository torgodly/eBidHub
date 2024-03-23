<?php

namespace App\Filament\Pages;

use App\Models\Auction;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Collection;


class CheckWinners extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'tabler-trophy';

    protected static string $view = 'filament.pages.check-winners';

    public static function getNavigationBadge(): ?string
    {
        return Auction::query()->where('end', '<', now())->where('approved', 1)->whereNull('winner_id')->count();
    }
    public static function getNavigationLabel(): string
    {
        return __(parent::getNavigationLabel());
    }

    public static function getNavigationGroup(): ?string
    {
        return __(parent::getNavigationGroup());
    }

    public function getTitle(): string
    {
        return __(parent::getTitle());
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Auction::query()->where('end', '<', now())->where('approved', 1)->whereNull('winner_id'))
            ->columns([
                TextColumn::make('title')->translateLabel()
                    ->searchable()
                    ->limit(20),
                TextColumn::make('price')->translateLabel()
                    ->numeric(
                        decimalPlaces: 0,
                        decimalSeparator: '.',
                        thousandsSeparator: ',',
                    )->prefix('LYD ')
                    ->sortable(),
                TextColumn::make('end')->translateLabel()
                    ->dateTime('Y-m-d H:i:s')
                    ->description(fn(Auction $record): string => Carbon::parse($record->end)->diffForHumans())
                    ->sortable(),
                TextColumn::make('end_price')->translateLabel()
                    ->numeric(
                        decimalPlaces: 0,
                        decimalSeparator: '.',
                        thousandsSeparator: ',',
                    )->prefix('LYD ')
                    ->sortable(),
            ])
            ->filters([
                // ...
            ])
            ->actions([

                //check winner action
                Action::make('Check Winners')
                    ->translateLabel()
                    ->icon('tabler-trophy')
                    ->color('success')
                    ->action(function (Auction $record): void {
                        $record->checkWinners();
                    })->successNotificationTitle(__('Winner Has Been Notified')),
                Action::make('View')->translateLabel()
                    ->url(fn(Auction $record): string => route('auctions.show', $record))
                    ->openUrlInNewTab()

            ])
            ->bulkActions([
                BulkAction::make('Check Winners')
                    ->translateLabel()
                    ->action(fn(Collection $records) => $records->each->checkWinners())
                    ->deselectRecordsAfterCompletion()
                    ->successNotificationTitle(__('Winners Has Been Notified')),
            ]);
    }

}
