<?php

namespace App\Filament\Pages;

use App\Models\Auction;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Pages\Page;

class ViewAuction extends Page implements HasInfolists
{
    use InteractsWithInfolists;


    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $slug = 'approve-auctions/{record}/view';
    protected static string $view = 'filament.pages.view-auction';


    public function mount(Auction $record): void
    {
        $this->record = $record;
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->record)
            ->schema([
                Section::make()
                    ->schema([
                        Split::make([
                            Grid::make(2)
                                ->schema([
                                    TextEntry::make('title')->translateLabel(),
                                    TextEntry::make('price')->translateLabel()->suffix("د.ل"),
                                    TextEntry::make('end')->translateLabel()
                                        ->dateTime('Y-m-d H:i:s'),
                                    TextEntry::make('status')->translateLabel()
                                        ->badge()
                                        ->formatStateUsing(fn(string $state): string => match ($state) {
                                            'ending soon' => __('Ending Soon'),
                                            'active' => __('Active'),
                                            'closed' => __('Closed'),
                                        })
                                        ->color(fn(string $state): string => match ($state) {
                                            'ending soon' => 'warning',
                                            'active' => 'success',
                                            'closed' => 'danger',
                                        }),
                                    TextEntry::make('approved')->label('Approve Status')
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
                                    TextEntry::make('bids_count')->translateLabel(),

                                    TextEntry::make('categories.name')->translateLabel()->badge(),
                                    TextEntry::make('minimum_bid')->translateLabel()->suffix("د.ل"),
                                    IconEntry::make('buy_now')->translateLabel()
                                        ->boolean(),
                                    TextEntry::make('buy_now_price')->translateLabel()->suffix("د.ل")->default(0),


                                ]),

                        ])->from('lg'),
                    ]),
                Section::make('Images')
                    ->translateLabel()
                    ->schema([
                        SpatieMediaLibraryImageEntry::make('media')
                            ->Collection('Auctions')
                            ->hiddenLabel(),
                    ])
                    ->collapsible(),

                Section::make('Content')
                    ->translateLabel()
                    ->schema([
                        TextEntry::make('description')
                            ->prose()
                            ->markdown()
                            ->hiddenLabel(),
                    ])
                    ->collapsible(),
            ]);
    }


}
