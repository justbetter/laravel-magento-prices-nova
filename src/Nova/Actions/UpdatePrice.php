<?php

namespace JustBetter\MagentoPricesNova\Nova\Actions;

use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Support\Collection;
use JustBetter\MagentoPrices\Jobs\Update\UpdatePriceJob;
use JustBetter\MagentoPrices\Models\Price;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;

class UpdatePrice extends Action
{
    public $name = 'Update to Magento';

    public function handle(ActionFields $fields, Collection $models): ActionResponse
    {
        $models->each(fn (Price $price): PendingDispatch => UpdatePriceJob::dispatch($price));

        return ActionResponse::message(__('Updating'));
    }
}
