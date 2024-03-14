<?php

namespace App\Filament\Exports;

use App\Models\ProductFlow;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ProductFlowExporter extends Exporter
{
    protected static ?string $model = ProductFlow::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('product.name')->label("Product Name"),
            ExportColumn::make('type')->label("Mutation Type"),
            ExportColumn::make('amount'),
            ExportColumn::make('desc')->label("Description"),
            ExportColumn::make('mutate_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your product flow export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
