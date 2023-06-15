<?php

namespace JustBetter\MagentoPricesNova\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use JustBetter\MagentoPrices\Jobs\RetrievePriceJob;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;

class Retry extends Action
{
    use InteractsWithQueue;
    use Queueable;

    public $name = 'Retrieve & Send to Magento';
    public $showInline = true;
    public $withoutConfirmation = true;

    public function handle(ActionFields $fields, Collection $models): ActionResponse
    {
        foreach ($models as $model) {
            RetrievePriceJob::dispatch($model->sku, true);
        }

        return ActionResponse::message('Started');
    }
}
