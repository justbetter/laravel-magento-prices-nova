<?php

namespace JustBetter\MagentoPricesNova\Nova\Actions;

use Illuminate\Support\Collection;
use JustBetter\MagentoPrices\Jobs\Retrieval\RetrievePriceJob;
use JustBetter\MagentoPrices\Models\Price;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Http\Requests\NovaRequest;

class RetrievePrice extends Action
{
    public function __construct()
    {
        $this->withName(__('Retrieve selected price'));
    }

    public function handle(ActionFields $fields, Collection $models): ActionResponse
    {
        /** @var bool $force */
        $force = $fields->get('force');

        $models->each(fn (Price $model) => RetrievePriceJob::dispatch($model->sku, $force));

        return ActionResponse::message(__('Retrieving...'));
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Boolean::make(__('Force Update'), 'force')
                ->help(__('Update the price to Magento, even if it has not changed')),
        ];
    }
}
