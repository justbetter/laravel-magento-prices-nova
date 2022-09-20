<?php

namespace JustBetter\MagentoPricesNova\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use JustBetter\MagentoPrices\Jobs\UpdatePriceJob;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class UpdatePrice extends Action
{
    use InteractsWithQueue;
    use Queueable;

    public $name = 'Update to Magento';

    public function handle(ActionFields $fields, Collection $models): array
    {
        foreach ($models as $model) {
            UpdatePriceJob::dispatch($model->sku, $fields->type);
        }

        return Action::message('Started retrieve');
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Boolean::make('Force', 'force')
                ->help('When checked it will ignore the lock that prevents prices to be updated only once at the same time'),

            Number::make('# of products per chunk', 'chunk')
                ->help('Number of products to send to Magento per request')
                ->default(1),

            Select::make('Type')
                ->options([
                    null => 'All',
                    'base' => 'Base prices',
                    'tier' => 'Tier prices',
                    'special' => 'Special prices',
                ])
        ];
    }
}
