<?php

namespace JustBetter\MagentoPricesNova\Nova\Actions;

use Illuminate\Support\Collection;
use JustBetter\MagentoPrices\Models\Price;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Http\Requests\NovaRequest;

class RetryFailed extends Action
{
    public $name = 'Reset Failed Status';

    public function handle(ActionFields $fields, Collection $models): ActionResponse
    {
        /** @var bool $retrieve */
        $retrieve = $fields->get('retrieve');

         /** @var bool $update */
        $update = $fields->get('update');

        $models->each(fn (Price $price): bool => $price->update([
            'sync' => true,
            'failed_at' => null,
            'fail_count' => 0,
            'retrieve' => $retrieve,
            'update' => $update
        ]));

        return ActionResponse::message(__('Reset :count prices', ['count' => $models->count()]));
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Boolean::make(__('Retrieve'), 'retrieve')
                ->help(__('Set the retrieve flag')),

            Boolean::make(__('Update'), 'update')
                ->help(__('Set the update flag')),
        ];
    }
}

