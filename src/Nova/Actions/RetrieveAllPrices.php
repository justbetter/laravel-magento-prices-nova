<?php

namespace JustBetter\MagentoPricesNova\Nova\Actions;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use JustBetter\MagentoPrices\Jobs\Retrieval\RetrieveAllPricesJob;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Http\Requests\NovaRequest;

class RetrieveAllPrices extends Action
{
    public $name = 'Retrieve All Prices';
    public $standalone = true;

    public function handle(ActionFields $fields, Collection $models): ActionResponse
    {
        /** @var ?string $from */
        $from = $fields->get('from');

        if ($from !== null) {
            $carbon = Carbon::parse($from);
        }

        RetrieveAllPricesJob::dispatch($carbon ?? null);

        return ActionResponse::message(__('Retrieving'));
    }

    public function fields(NovaRequest $request): array
    {
        return [
            DateTime::make(__('From'), 'from')
                ->help(__('Optional, retrieve updated prices from this date')),
        ];
    }
}

