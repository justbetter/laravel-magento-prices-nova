<?php

namespace JustBetter\MagentoPricesNova\Nova\Metrics;

use JustBetter\MagentoPrices\Models\MagentoPrice;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Metrics\ValueResult;

class PricesToRetrieve extends Value
{
    public $name = 'To Retrieve';

    public function calculate(NovaRequest $request): ValueResult
    {
        return $this->sum($request, MagentoPrice::class, 'retrieve');
    }

    public function uriKey(): string
    {
        return 'prices-to-retrieve';
    }
}
