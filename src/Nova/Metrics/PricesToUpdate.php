<?php

namespace JustBetter\MagentoPricesNova\Nova\Metrics;

use JustBetter\MagentoPrices\Models\MagentoPrice;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Metrics\ValueResult;

class PricesToUpdate extends Value
{
    public $name = 'Prices To Update';

    public function calculate(NovaRequest $request): ValueResult
    {
        return new ValueResult(
            MagentoPrice::query()->where('update', '=', true)->count()
        );
    }

    public function uriKey(): string
    {
        return 'prices-to-update';
    }
}
