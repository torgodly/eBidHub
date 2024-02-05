<?php

namespace App\Filament\Seller\Pages;

use App\Models\Auction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class MyCustomers extends Page implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static string $view = 'filament.seller.pages.my-customers';
    protected static ?string $navigationGroup = 'Auctions';

    public static function getNavigationLabel(): string
    {
        return __(parent::getNavigationLabel());
    }

    public function getTitle(): string
    {
        return __(parent::getTitle());
    }

    public static function getNavigationGroup(): ?string
    {
        return __(parent::getNavigationGroup());
    }




    public function table(Table $table): Table
    {
        return $table
            ->query(Auction::with('winner')->where('end', '<', now()))
            ->columns([
                TextColumn::make('winner_name')->label('Winner Name')->translateLabel(),
                TextColumn::make('winner.email')->label('Winner Email')->translateLabel(),
                TextColumn::make('phone_number')->translateLabel(),
                TextColumn::make('end_price')->suffix('د.ل')->translateLabel(),
                TextColumn::make('title')->translateLabel(),

            ])
            ->filters([
                // ...
            ])
            ->actions([
                Action::make('View')->translateLabel()
                    ->url(fn(Auction $record): string => route('auctions.show', $record))
                    ->openUrlInNewTab()
            ])
            ->bulkActions([
                // ...
            ]);
    }
}
