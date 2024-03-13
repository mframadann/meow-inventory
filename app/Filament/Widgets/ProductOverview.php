<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\ProductFlow;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Product', Product::count()),
            Stat::make("Mutation", ProductFlow::count())
        ];
    }
}
