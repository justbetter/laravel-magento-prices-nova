<?php

namespace JustBetter\MagentoPricesNova\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use JustBetter\MagentoPrices\Jobs\SyncMissingPricesJob;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class MissingPrices extends Action
{
    use InteractsWithQueue;
    use Queueable;

    public $name = 'Search missing prices in Magento';
    public $standalone = true;

    public function handle(ActionFields $fields, Collection $models): array
    {
        SyncMissingPricesJob::dispatch();

        return Action::message('Started');
    }
}

