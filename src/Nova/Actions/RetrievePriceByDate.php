<?php

namespace JustBetter\MagentoPricesNova\Nova\Actions;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use JustBetter\MagentoPrices\Jobs\RetrievePricesJob;
use Laravel\Nova\Actions\Action;
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

    public function handle(ActionFields $fields, Collection $models): array
    {
        if (!Carbon::canBeCreatedFromFormat($fields->from, static::DATE_FORMAT)) {
            return Action::danger('Invalid date');
        }

        $from = Carbon::createFromFormat(static::DATE_FORMAT, $fields->from);

        RetrievePricesJob::dispatch($from, $fields->force);

        return Action::message('Started retrieve');
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Date::make(__('From date'), 'from'),
            Boolean::make(__('Force update'), 'force')
        ];
    }
}
