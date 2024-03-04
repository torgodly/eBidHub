<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'المزادات';

    public static function getModelLabel(): string
    {
        return __(parent::getModelLabel());
    }

    public static function getPluralLabel(): ?string
    {
        return __('Categories');
    }


    public static function getNavigationGroup(): ?string
    {
        return __(parent::getNavigationGroup());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()->translateLabel(),
                //AuctionsCount
                Tables\Columns\TextColumn::make('auctions_count')
                    ->label(__('Auctions Count'))
                    ->searchable()
                    ->translateLabel(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth('md')
                    ->modalHeading(__('Edit Category'))
                    ->modalDescription(__('Edit this category'))
                    ->modalSubmitActionLabel(__('Edit Category'))
                    ->modalIcon('heroicon-o-tag')
                    ->requiresConfirmation(),
                Tables\Actions\DeleteAction::make()->hidden(fn($record) => $record->auctions()->exists())

            ])
            ->bulkActions([
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()

            ])->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListCategories::route('/'),
//            'create' => Pages\CreateCategory::route('/create'),
//            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->unique(Category::class, 'name')
                    ->maxLength(255)->columnSpanFull()->translateLabel(),

            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Tables\Actions\CreateAction::make()
                ->modalWidth('md')
                ->modalHeading(__('Add Category'))
                ->modalDescription(__('Add a new category'))
                ->modalSubmitActionLabel(__('Add Category'))
                ->modalIcon('heroicon-o-tag')
                ->requiresConfirmation(),

        ];
    }
}
