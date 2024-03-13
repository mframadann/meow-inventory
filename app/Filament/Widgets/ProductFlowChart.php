<?php

namespace App\Filament\Widgets;

use App\Models\ProductFlow;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ProductFlowChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        $data = Trend::model(ProductFlow::class)
               ->between(
                   start: now()->subYear(),
                   end: now(),
               )
               ->dateColumn('mutate_at')
               ->perMonth()
               ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Mutation Traffics',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
