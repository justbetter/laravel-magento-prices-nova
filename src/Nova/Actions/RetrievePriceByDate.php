<?php

namespace JustBetter\MagentoPricesNova\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use JustBetter\MagentoPrices\Jobs\RetrievePricesJob;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Http\Requests\NovaRequest;

class RetrievePriceByDate extends Action
{
    use InteractsWithQueue;
    use Queueable;

    const DATE_FORMAT = 'Y-m-d';

    public $standalone = true;
    public $name = 'Retrieve price by date';

    public function handle(ActionFields $fields, Collection $models): ActionResponse
    {
        if (!Carbon::canBeCreatedFromFormat($fields->from, static::DATE_FORMAT)) {
            return ActionResponse::danger('Invalid date');
        }

        $from = Carbon::createFromFormat(static::DATE_FORMAT, $fields->from);

        RetrievePricesJob::dispatch($from, $fields->force);

        return ActionResponse::message('Started retrieve');
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Date::make(__('From date'), 'from'),
            Boolean::make(__('Force update'), 'force')
        ];
    }
}
