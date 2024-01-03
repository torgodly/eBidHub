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

    public function table(Table $table): Table
    {
        return $table
            ->query(Auction::with('winner'))
            ->columns([
                TextColumn::make('winner.name'),
                TextColumn::make('winner.email')->label('Winner Email'),
                TextColumn::make('phone_number'),
                TextColumn::make('title'),

            ])
            ->filters([
                // ...
            ])
            ->actions([
                Action::make('view')
                    ->url(fn(Auction $record): string => route('auctions.show', $record))
                    ->openUrlInNewTab()
            ])
            ->bulkActions([
                // ...
            ]);
    }
}
