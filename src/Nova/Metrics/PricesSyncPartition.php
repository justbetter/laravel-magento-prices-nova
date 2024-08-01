<?php

namespace JustBetter\MagentoPricesNova\Nova\Metrics;

use JustBetter\MagentoPrices\Models\Price;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;
use Laravel\Nova\Metrics\PartitionResult;

class PricesSyncPartition extends Partition
{
    public $name = 'Keep in Sync';

    public function calculate(NovaRequest $request): PartitionResult
    {
        return $this->count($request, Price::class, 'sync')
            ->label(fn($sync) => $sync ? 'Yes' : 'No');
    }

    public function uriKey(): string
    {
        return 'prices-sync-partition';
    }
}
