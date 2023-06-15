<?php

namespace JustBetter\MagentoPricesNova\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use JustBetter\MagentoPrices\Jobs\RetrievePriceJob;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Http\Requests\NovaRequest;

class RetrievePrice extends Action
{
    use InteractsWithQueue;
    use Queueable;

    public $name = 'Retrieve';

    public function handle(ActionFields $fields, Collection $models): ActionResponse
    {
        $models->each(fn($model) => RetrievePriceJob::dispatch($model->sku, $fields->force));

        return ActionResponse::message('Started retrieve');
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Boolean::make('Force Update', 'force')
        ];
    }
}
