<?php

namespace App\Filament\Pages;

use App\Models\Auction;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class ApproveAuctions extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static string $view = 'filament.pages.approve-auctions';
    public static function getNavigationBadge(): ?string
    {
        return Auction::query()->where('approved', false)->count();
    }
    public static function getNavigationLabel(): string
    {
        return __(parent::getNavigationLabel());
    }

    public function getTitle(): string
    {
        return __(parent::getTitle());
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Auction::query()->where('approved', false))
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->limit(20),
                TextColumn::make('price')
                    ->numeric(
                        decimalPlaces: 0,
                        decimalSeparator: '.',
                        thousandsSeparator: ',',
                    )->prefix('LYD ')
                    ->sortable(),
                TextColumn::make('minimum_bid')
                    ->numeric(
                        decimalPlaces: 0,
                        decimalSeparator: '.',
                        thousandsSeparator: ',',
                    )->prefix('LYD ')
                    ->sortable(),

                TextColumn::make('end')
                    ->dateTime('Y-m-d H:i:s')
                    ->description(fn(Auction $record): string => Carbon::parse($record->end)->diffForHumans())
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'active' => 'success',
                        'closed' => 'danger',
                        'ending soon' => 'warning',
                    }),

            ])
            ->filters([
                // ...
            ])
            ->actions([
                Action::make(__('Approve'))
                    ->requiresConfirmation()
                    ->action(function (Auction $record) {
                        $record->approve();
                        Notification::make()
                            ->title(__("Auction Approved Successfully"))
                            ->success()
                            ->send();
                    })->sendSuccessNotification(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('Approve')
                        ->requiresConfirmation()
                        ->action(fn(Collection $records) => $records->each->approve())->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}
