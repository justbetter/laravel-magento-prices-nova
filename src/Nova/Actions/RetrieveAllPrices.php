<?php

namespace JustBetter\MagentoPricesNova\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use JustBetter\MagentoPrices\Jobs\RetrievePricesJob;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class RetrieveAllPrices extends Action
{
    use InteractsWithQueue;
    use Queueable;

    public $standalone = true;
    public $name = 'Retrieve All Prices';

    public function handle(ActionFields $fields, Collection $models): array
    {
        RetrievePricesJob::dispatch();

        return Action::message('Started retrieving');
    }
}

