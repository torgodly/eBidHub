<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class Users extends Page implements HasTable
{

    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static string $view = 'filament.pages.users';

    public static function getNavigationLabel(): string
    {
        return __(parent::getNavigationLabel());
    }

    public static function getNavigationGroup(): ?string
    {
        return __(parent::getNavigationGroup());
    }

    public function getTitle(): string
    {
        return __(parent::getTitle());
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query())
            ->columns([
                TextColumn::make('name')->sortable()->searchable()->label('Name')->translateLabel(),
                TextColumn::make('email')->sortable()->searchable()->label('Email')->copyable()->copyMessage(__('Email copied to clipboard.'))->translateLabel(),
                TextColumn::make('phone_number')->sortable()->searchable()->translateLabel(),
                TextColumn::make('balance')->sortable()->searchable()->prefix('LYD ')->badge()->color(
                    fn(string $state): string => match ($state) {
                        '0' => 'warning',
                        default => 'success',
                    }
                )->icon('heroicon-o-currency-dollar')->translateLabel(),
                ToggleColumn::make('active')->label(
                    'Account Status'
                )->translateLabel()
            ])
            ->filters([
                // ...
            ])
            ->actions([

                Action::make(__('Add Balance'))
                    ->fillForm(fn(User $record): array => [
                        'balance' => $record->balance,
                    ])
                    ->form([
                        TextInput::make('balance')
                            ->minValue(0)
                            ->label('Balance')->numeric()->maxValue(100000000)
                            ->required()->translateLabel()->prefix('د.ل')
                    ])
                    ->action(function (array $data, User $record): void {
                        $record->balance = $data['balance'];
                        $record->save();
                        Notification::make()
                            ->title(__('Balance Added Successfully'))
                            ->success()
                            ->send();
                    })->requiresConfirmation()
                    ->modalHeading(__('Add Balance'))
                    ->modalDescription(__('Add balance to user account'))
                    ->modalSubmitActionLabel(__('Add Balance'))
                    ->modalIcon('heroicon-o-currency-dollar')
                    ->modalWidth('md')
                    ->icon('heroicon-o-currency-dollar')

                ,
//                    ->confirmable()

            //activete and de activeate user account


            ])
            ->bulkActions([
                // ...
            ]);
    }

}
