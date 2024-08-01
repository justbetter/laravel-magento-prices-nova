<?php

namespace JustBetter\MagentoPricesNova\Nova\Metrics;

use JustBetter\MagentoPrices\Models\Price;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Metrics\ValueResult;

class PricesToRetrieve extends Value
{
    public $name = 'Prices To Retrieve';

    public function calculate(NovaRequest $request): ValueResult
    {
        return new ValueResult(
            Price::query()->where('retrieve', '=', true)->count()
        );
    }

    public function uriKey(): string
    {
        return 'prices-to-retrieve';
    }
}
