<?php

namespace JustBetter\MagentoPricesNova\Nova\Actions;

use Illuminate\Support\Collection;
use JustBetter\MagentoPrices\Jobs\SyncMissingPricesJob;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;

class MissingPrices extends Action
{
    public $name = 'Search missing prices in Magento';
    public $standalone = true;

    public function handle(ActionFields $fields, Collection $models): ActionResponse
    {
        SyncMissingPricesJob::dispatch();

        return ActionResponse::message(__('Searching for missing prices'));
    }
}

