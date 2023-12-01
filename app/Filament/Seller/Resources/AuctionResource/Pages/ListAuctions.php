<?php

namespace App\Filament\Seller\Resources\AuctionResource\Pages;

use App\Filament\Seller\Resources\AuctionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAuctions extends ListRecords
{
    protected static string $resource = AuctionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
