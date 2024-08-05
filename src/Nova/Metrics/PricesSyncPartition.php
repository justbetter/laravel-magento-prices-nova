<?php

namespace JustBetter\MagentoPricesNova\Nova\Metrics;

use JustBetter\MagentoPrices\Models\Price;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;
use Laravel\Nova\Metrics\PartitionResult;

class PricesSyncPartition extends Partition
{
    public function __construct()
    {
        $this->name = __('Keep in sync');
    }

    public function calculate(NovaRequest $request): PartitionResult
    {
        return $this
            ->count($request, Price::class, 'sync')
            ->label(fn (mixed $sync): string => $sync ? __('Yes') : __('No'));
    }

    public function uriKey(): string
    {
        return 'prices-sync-partition';
    }
}
