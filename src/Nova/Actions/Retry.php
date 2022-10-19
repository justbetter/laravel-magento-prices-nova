<?php

namespace JustBetter\MagentoPricesNova\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use JustBetter\MagentoPrices\Jobs\RetrievePricesJob;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class Retry extends Action
{
    use InteractsWithQueue;
    use Queueable;

    public $name = 'Retrieve & Send to Magento';
    public $showInline = true;
    public $withoutConfirmation = true;

    public function handle(ActionFields $fields, Collection $models): array
    {
        foreach ($models as $model) {
            RetrievePricesJob::dispatch($model->sku, true);
        }

        return Action::message('Started');
    }
}
