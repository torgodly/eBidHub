<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuctionResource\Pages;
use App\Filament\Resources\AuctionResource\RelationManagers;
use App\Models\Auction;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AuctionResource extends Resource
{
    protected static ?string $model = Auction::class;

    protected static ?string $navigationIcon = 'tabler-building-store';
    protected static ?string $navigationGroup = 'المزادات';

    public static function getModelLabel(): string
    {
        return __('Auction');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Auctions');
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('Auction-image')->translateLabel()
                    ->label('Images')
                    ->collection('Auctions')
                    ->circular()
                    ->stacked()
                    ->limit(3),
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
                TextColumn::make('end_price')->translateLabel()
                    ->numeric(
                        decimalPlaces: 0,
                        decimalSeparator: '.',
                        thousandsSeparator: ',',
                    )->prefix('LYD ')
                    ->sortable(),

                TextColumn::make('minimum_bid')->translateLabel()
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
                TextColumn::make('status')->translateLabel()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'active' => 'success',
                        'closed' => 'danger',
                        'ending soon' => 'warning',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'ending soon' => __('Ending Soon'),
                        'active' => __('Active'),
                        'closed' => __('Closed'),
                    })
                ,
                TextColumn::make('approved')->label('Approve Status')
                    ->translateLabel()
                    ->default('Pending')
                    ->formatStateUsing(function (string $state): string {
                        if ($state === '1') {
                            return __('Approved');
                        }
                        if ($state === '0') {
                            return __('Declined');
                        }
                        return __('Pending');
                    })
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        '1' => 'success',
                        '0' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('bids_count')->translateLabel()

            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        Forms\Components\Select::make('Status')->options(
                            [
                                'active' => __('Active'),
                                'closed' => __('Closed'),
                                'ending soon' => __('Ending Soon')
                            ]
                        )->translateLabel(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['Status'] === 'active',
                                fn(Builder $query, $date): Builder => $query->where('end', '>', now())->whereNull('winner_id'),
                            )->when(
                                $data['Status'] === 'closed',
                                fn(Builder $query, $date): Builder => $query->where('end', '<', now())->orWhereNotNull('winner_id'),
                            )->when(
                                $data['Status'] === 'ending soon',
                                fn(Builder $query, $date): Builder => $query->where('end', '<', now()->addHours(3))->whereNull('winner_id'),
                            );
                    })

            ])
            ->actions([

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuctions::route('/'),
        ];
    }
}
