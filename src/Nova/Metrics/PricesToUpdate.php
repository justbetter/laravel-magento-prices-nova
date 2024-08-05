<?php

namespace JustBetter\MagentoPricesNova\Nova\Metrics;

use Illuminate\Database\Eloquent\Builder;
use JustBetter\MagentoPrices\Models\Price;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Metrics\ValueResult;

class PricesToUpdate extends Value
{
    public function calculate(NovaRequest $request): ValueResult
    {
        return new ValueResult(
            Price::query()
                ->where('sync', '=', true)
                ->where('update', '=', true)
                ->whereHas('product', function (Builder $query): void {
                    $query->where('exists_in_magento', '=', true);
                })
                ->count()
        );
    }

    public function uriKey(): string
    {
        return 'prices-to-update';
    }
}
