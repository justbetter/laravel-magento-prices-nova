<?php

namespace JustBetter\MagentoPricesNova\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;
use JustBetter\MagentoPrices\Jobs\RetrievePricesJob;
use JustBetter\MagentoPrices\Jobs\UpdatePricesJob;
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

            $chain = [
                new RetrievePricesJob($model->sku),
                new UpdatePricesJob([['id' => $model->id]], true)
            ];

            Bus::dispatchChain($chain);

        }

        return Action::message('Started');
    }
}
