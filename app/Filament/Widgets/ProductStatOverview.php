<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductFlow;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductStatOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Product', Product::count()),
            Stat::make("Mutation", ProductFlow::count()),
            Stat::make("Product Category", ProductCategory::count())
        ];
    }
}
