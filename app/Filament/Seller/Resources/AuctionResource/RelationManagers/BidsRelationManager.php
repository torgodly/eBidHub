<?php

namespace App\Filament\Seller\Resources\AuctionResource\RelationManagers;

use App\Models\Bid;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BidsRelationManager extends RelationManager
{
    protected static string $relationship = 'bids';

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->orderBy('created_at', 'desc');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Bids')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->sortable(),
                Tables\Columns\TextColumn::make('amount')->money('LYD')->sortable(),
                TextColumn::make('created_at')
                    ->dateTime('Y-m-d H:i')
                    ->description(fn(Bid $record): string => $record->created_at->diffForHumans(), position: 'above')
                    ->sortable(),
            ])
            ->filters([
            ])
            ->headerActions([
//                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
//                Tables\Actions\EditAction::make(),
//                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
            ])
            ->emptyStateActions([
//                Tables\Actions\CreateAction::make(),
            ]);
    }

}
