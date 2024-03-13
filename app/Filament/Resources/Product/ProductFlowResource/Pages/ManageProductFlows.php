<?php

namespace App\Filament\Resources\Product\ProductFlowResource\Pages;

use App\Filament\Resources\Product\ProductFlowResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProductFlows extends ManageRecords
{
    protected static string $resource = ProductFlowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
