<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MessageResource\Pages;
use App\Filament\Resources\MessageResource\RelationManagers;
use App\Models\Message;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MessageResource extends Resource
{
    protected static ?string $model = Message::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox';

    public static function getModelLabel(): string
    {
        return __('Messages');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Messages');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('message')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_read')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_read')
                    ->translateLabel()
                    ->boolean()
                    ->sortable()
                ,

            ])
            ->filters([
                //
            ])
            ->actions([
//                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('View')
                    ->translateLabel()
                    ->modalSubmitActionLabel(fn(Message $record) => $record->is_read ? __('Mark as Unread') : __('Mark as Read'))
                    ->action(fn(Message $record) => $record->toggleIsRead())
                    ->infolist([
                        TextEntry::make('name')
                        ->translateLabel(),
                        TextEntry::make('email')
                        ->translateLabel(),
                        TextEntry::make('phone')
                        ->translateLabel(),
                        TextEntry::make('message')
                        ->translateLabel(),
                    ])->modalWidth('md')
//                    ->(fn(Message $record) => $record->is_read ? 'Mark as Unread' : 'Mark as Read')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            TextEntry::make('id')
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
            'index' => Pages\ListMessages::route('/'),
//            'create' => Pages\CreateMessage::route('/create'),
//            'edit' => Pages\EditMessage::route('/{record}/edit'),
        ];
    }
}
