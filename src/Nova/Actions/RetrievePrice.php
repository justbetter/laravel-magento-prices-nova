<?php

namespace JustBetter\MagentoPricesNova\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use JustBetter\MagentoPrices\Jobs\RetrievePricesJob;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Http\Requests\NovaRequest;

class RetrievePrice extends Action
{
    use InteractsWithQueue;
    use Queueable;

    public $name = 'Retrieve';

    public function handle(ActionFields $fields, Collection $models): array
    {
        $models->each(fn($model) => RetrievePricesJob::dispatch($model->sku, null, $fields->force));

        return Action::message('Started retrieve');
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Boolean::make('Force Update', 'force')
        ];
    }
}
