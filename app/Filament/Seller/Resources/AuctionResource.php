<?php

namespace App\Filament\Seller\Resources;

use App\Filament\Seller\Resources\AuctionResource\Pages;
use App\Filament\Seller\Resources\AuctionResource\RelationManagers;
use App\Models\Auction;
use Carbon\Carbon;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AuctionResource extends Resource
{
    protected static ?string $model = Auction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Order')
                        ->schema([
                            TextInput::make('title')
                                ->required()
                                ->maxLength(255),

                            MarkdownEditor::make('description')
                                ->toolbarButtons([
                                    'blockquote',
                                    'bold',
                                    'bulletList',
                                    'heading',
                                    'italic',
                                    'link',
                                    'orderedList',
                                    'redo',
                                    'undo',
                                ])->required()
                        ]),
                    Wizard\Step::make(__('Price & Date'))
                        ->schema([
                            TextInput::make('price')
                                ->required()
                                ->numeric()
                                ->prefix('LYD'),
                            DateTimePicker::make('start')
                                ->prefix('Starts')
                                ->required(),
                            DateTimePicker::make('end')
                                ->prefix('Ends')
                                ->required(),
                        ]),
                    Wizard\Step::make(__('Product Information'))
                        ->schema([
                            KeyValue::make(__('info'))
                                ->keyLabel(__('Info name'))
                                ->valueLabel(__('Info text'))
                                ->addActionLabel(__('Add New Info'))
                        ]),
                    Wizard\Step::make('images')
                        ->schema([
                            SpatieMediaLibraryFileUpload::make('media')
                                ->collection('Auctions')
                                ->multiple()
                                ->enableReordering()
                                ->responsiveImages()
                                ->hiddenLabel(),
                        ]),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('Auction-image')
                    ->label('Image')
                    ->collection('Auctions')
                    ->circular()
                    ->stacked(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('price')
                    ->money('LYD')
                    ->sortable(),

                TextColumn::make('start')
                    ->dateTime('Y-m-d H:i:s')
                    ->description(fn(Auction $record): string => Carbon::parse($record->start)->diffForHumans())
                    ->sortable(),
                TextColumn::make('end')
                    ->dateTime('Y-m-d H:i:s')
                    ->description(fn(Auction $record): string => Carbon::parse($record->start)->diffForHumans())
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'upcoming' => 'warning',
                        'active' => 'success',
                        'closed' => 'danger',
                    })
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'create' => Pages\CreateAuction::route('/create'),
            'edit' => Pages\EditAuction::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }
}
