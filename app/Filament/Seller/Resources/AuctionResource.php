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
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
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
                    Wizard\Step::make('General Information')
                        ->schema([
                            TextInput::make('title')
                                ->required()
                                ->maxLength(255),
                            Textarea::make('about')
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
                            TextInput::make('minimum_bid')
                                ->required()
                                ->numeric()
                                ->prefix('LYD'),
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
                                ->reorderable()
                                ->responsiveImages()
                                ->hiddenLabel()
                                ->imageEditor(),
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
                    ->stacked()
                    ->limit(3),
                TextColumn::make('title')
                    ->searchable()
                    ->limit(20),
                TextColumn::make('price')
                    ->money('LYD')
                    ->sortable(),

                TextColumn::make('minimum_bid')
                    ->money('LYD')
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
                    }),
                TextColumn::make('bids_count')
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            RelationManagers\BidsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'view' => Pages\ViewAuction::route('/{record}/show'),
            'index' => Pages\ListAuctions::route('/'),
            'create' => Pages\CreateAuction::route('/create'),
            'edit' => Pages\EditAuction::route('/{record}/edit'),
        ];
    }

    //infolist
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()
                    ->schema([
                        Split::make([
                            Grid::make(2)
                                ->schema([
                                    TextEntry::make('title'),
                                    TextEntry::make('price')->money('LYD'),

                                    TextEntry::make('start')
                                        ->dateTime('Y-m-d H:i:s')
                                        ->formatStateUsing(fn(string $state): string => Carbon::parse($state)->diffForHumans()),
                                    TextEntry::make('end')
                                        ->dateTime('Y-m-d H:i:s')
                                        ->formatStateUsing(fn(string $state): string => Carbon::parse($state)->diffForHumans()),

                                    TextEntry::make('status')
                                        ->badge()
                                        ->color(fn(string $state): string => match ($state) {
                                            'upcoming' => 'warning',
                                            'active' => 'success',
                                            'closed' => 'danger',
                                        }),
//                                    ]),
                                ]),

                        ])->from('lg'),
                    ]),
                Section::make('Images')
                    ->schema([
                        SpatieMediaLibraryImageEntry::make('media')
                            ->Collection('Auctions')
                            ->hiddenLabel()
                            ->columns(2)
                            ->stacked()
                        ,
                    ])
                    ->collapsible(),

                Section::make('Content')
                    ->schema([
                        TextEntry::make('description')
                            ->prose()
                            ->markdown()
                            ->hiddenLabel(),
                    ])
                    ->collapsible(),
            ]);
    }


    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id())->orderBy('created_at', 'desc');
    }
}
