<?php

namespace JustBetter\MagentoPricesNova\Nova\Metrics;

use JustBetter\MagentoPrices\Models\Price;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;
use Laravel\Nova\Metrics\TrendResult;

class PriceUpdatesPerDay extends Trend
{
    public function calculate(NovaRequest $request): TrendResult
    {
        return $this->countByDays($request, Price::class, 'last_updated');
    }

    public function ranges(): array
    {
        return [
            30 => '30 Days',
            60 => '60 Days',
            90 => '90 Days',
        ];
    }

    public function uriKey(): string
    {
        return 'price-updates-per-day';
    }
}
