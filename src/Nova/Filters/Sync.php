<?php

namespace JustBetter\MagentoPricesNova\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class Sync extends Filter
{
    /** @param Builder $query */
    public function apply(NovaRequest $request, $query, $value): Builder
    {
        return $query->where('sync', '=', $value);
    }

    public function options(NovaRequest $request): array
    {
        return [
            __('In sync') => 1,
            __('Not in sync') => 0
        ];
    }
}
