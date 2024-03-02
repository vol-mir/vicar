<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProductResource\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductStats extends StatsOverviewWidget
{
    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        return [
            Stat::make(__('widgets.total_products'), Product::count()),
            Stat::make(__('widgets.is_visible_total_products'), Product::where('is_visible', true)->count()),
        ];
    }
}
