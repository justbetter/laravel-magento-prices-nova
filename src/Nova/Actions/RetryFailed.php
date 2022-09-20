<?php

namespace JustBetter\MagentoPricesNova\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use JustBetter\MagentoPrices\Jobs\UpdatePricesJob;
use JustBetter\MagentoPrices\Models\MagentoPrice;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;

class RetryFailed extends Action
{
    use InteractsWithQueue;
    use Queueable;

    public $name = 'Retry Failed';

    public function handle(ActionFields $fields, Collection $models): array
    {
        foreach (MagentoPrice::where('last_failed', '!=', null)->chunk($fields->chunk) as $chunk) {
            UpdatePricesJob::dispatch($chunk->toArray(), $fields->force);
        }

        return Action::message('Retrying');
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Boolean::make('Force', 'force')
                ->help('When checked it will ignore the lock that prevents prices to be updated only once at the same time'),

            Number::make('# of products per chunk', 'chunk')
                ->help('Number of products to send to Magento per request')
                ->default(10)
        ];
    }
}

