<?php

namespace JustBetter\MagentoPricesNova\Nova\Metrics;

use JustBetter\MagentoPrices\Models\MagentoPrice;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Metrics\ValueResult;

class PricesToUpdate extends Value
{
    public $name = 'To Update';

    public function calculate(NovaRequest $request): ValueResult
    {
        return $this->sum($request, MagentoPrice::class, 'update');
    }

    public function uriKey(): string
    {
        return 'prices-to-update';
    }
}
