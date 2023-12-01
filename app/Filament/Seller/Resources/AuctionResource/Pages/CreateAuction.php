<?php

namespace App\Filament\Seller\Resources\AuctionResource\Pages;

use App\Filament\Seller\Resources\AuctionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAuction extends CreateRecord
{
    protected static string $resource = AuctionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
