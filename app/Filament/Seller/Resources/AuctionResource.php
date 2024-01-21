<?php

namespace App\Filament\Seller\Resources;

use App\Filament\Seller\Resources\AuctionResource\Pages;
use App\Filament\Seller\Resources\AuctionResource\RelationManagers;
use App\Models\Auction;
use Carbon\Carbon;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AuctionResource extends Resource
{
    protected static ?string $model = Auction::class;

    protected static ?string $navigationIcon = 'tabler-building-store';
    protected static ?string $navigationGroup = 'Auctions';


    public static function getModelLabel(): string
    {
        return __('Auction');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Auctions');
    }


    public static function getNavigationGroup(): ?string
    {
        return __(parent::getNavigationGroup());
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('General Information')->translateLabel()
                        ->schema([
                            Select::make('categories')
                                ->translateLabel()
                                ->multiple()
                                ->preload()
                                ->relationship('categories', 'name'),
                            TextInput::make('title')
                                ->translateLabel()
                                ->required()
                                ->maxLength(255),
                            Textarea::make('about')
                                ->translateLabel()
                                ->required()
                                ->maxLength(255),
                            MarkdownEditor::make('description')
                                ->translateLabel()
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
                    Wizard\Step::make(__('Price & Date'))->translateLabel()
                        ->schema([
                            TextInput::make('price')
                                ->translateLabel()
                                ->required()
                                ->numeric()
                                ->disabled(fn($record) => $record?->bids()?->exists())
                                ->dehydrated()
                                ->prefix('LYD'),
                            TextInput::make('minimum_bid')
                                ->translateLabel()
                                ->required()
                                ->numeric()
                                ->disabled(fn($record) => $record?->bids()?->exists())
                                ->dehydrated()
                                ->prefix('LYD'),
                            DateTimePicker::make('end')
                                ->translateLabel()
                                ->prefix('Ends')
                                ->disabled(fn($record) => $record?->bids()?->exists())
                                ->minDate(now())
                                ->dehydrated()
                                ->required()->native(false),
                            Toggle::make('buy_now')->label('Item is available for buy now')
                                ->translateLabel()
                                ->inline(false)->live(),
                            TextInput::make('buy_now_price')
                                ->translateLabel()
                                ->required()
                                ->numeric()
                                ->disabled(fn($record) => $record?->bids()?->exists())
                                ->dehydrated()
                                ->prefix('LYD')
                                ->visible(fn(Get $get): bool => $get('buy_now')),
                        ]),
                    Wizard\Step::make(__('Product Information'))->translateLabel()
                        ->schema([
                            KeyValue::make('info')
                                ->translateLabel()
                                ->keyLabel(__('Info name'))
                                ->valueLabel(__('Info text'))
                                ->addActionLabel(__('Add New Info'))->live()
                        ]),
                    Wizard\Step::make('Images')->translateLabel()
                        ->schema([
                            SpatieMediaLibraryFileUpload::make('media')
                                ->collection('Auctions')
                                ->multiple()
                                ->reorderable()
                                ->responsiveImages()
                                ->hiddenLabel()
                                ->imageEditor(),
                        ]),
                ])->columnSpanFull()->skippable(fn($record) => $record !== null)
                //skipable on edit

                ,
            ]);
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
                    }),
                TextColumn::make('bids_count')->translateLabel()
            ])
            ->filters([

            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()->hidden(fn($record) => $record->bids()?->exists()),
                ])
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
                                    TextEntry::make('end')
                                        ->dateTime('Y-m-d H:i:s')
                                        ->formatStateUsing(fn(string $state): string => Carbon::parse($state)->diffForHumans()),
                                    TextEntry::make('status')
                                        ->badge()
                                        ->color(fn(string $state): string => match ($state) {
                                            'ending soon' => 'warning',
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
