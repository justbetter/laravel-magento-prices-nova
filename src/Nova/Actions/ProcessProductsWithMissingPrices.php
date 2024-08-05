<?php

namespace JustBetter\MagentoPricesNova\Nova\Actions;

use Illuminate\Support\Collection;
use JustBetter\MagentoPrices\Jobs\Utility\ProcessProductsWithMissingPricesJob;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;

class ProcessProductsWithMissingPrices extends Action
{
    public function __construct()
    {
        $this
            ->withName(__('Search missing prices in Magento'))
            ->standalone();
    }

    public function handle(ActionFields $fields, Collection $models): ActionResponse
    {
        ProcessProductsWithMissingPricesJob::dispatch();

        return ActionResponse::message(__('Searching...'));
    }
}
