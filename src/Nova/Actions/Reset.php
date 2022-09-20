<?php

namespace JustBetter\MagentoPricesNova\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use JustBetter\MagentoPrices\Jobs\RetrievePricesJob;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\DestructiveAction;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Http\Requests\NovaRequest;

class Reset extends DestructiveAction
{
    use InteractsWithQueue;
    use Queueable;

    public $name = 'Reset prices';
    public $standalone = true;

    public function handle(ActionFields $fields, Collection $models): array
    {
        DB::table('magento_prices')
            ->where('sku', '>', 0)
            ->delete();

        if ($fields->retrieve) {
            RetrievePricesJob::dispatch();
        }

        return Action::message('Removed all prices');
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Heading::make('This will remove ALL prices'),

            Boolean::make('Retrieve', 'retrieve')
                ->help('Retrieve new prices after removal'),
        ];
    }
}

