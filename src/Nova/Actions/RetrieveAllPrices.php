<?php

namespace JustBetter\MagentoPricesNova\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use JustBetter\MagentoPrices\Jobs\RetrievePricesJob;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;

class RetrieveAllPrices extends Action
{
    use InteractsWithQueue;
    use Queueable;

    public $standalone = true;
    public $name = 'Retrieve All Prices';

    public function handle(ActionFields $fields, Collection $models): ActionResponse
    {
        RetrievePricesJob::dispatch();

        return ActionResponse::message('Started retrieving');
    }
}

