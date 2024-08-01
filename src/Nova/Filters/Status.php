<?php

namespace JustBetter\MagentoPricesNova\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class Status extends Filter
{
    /** @param Builder $query */
    public function apply(NovaRequest $request, $query, $value): Builder
    {
        return $query->where($value, true);
    }

    public function options(NovaRequest $request): array
    {
        return [
            __('To retrieve') => 'retrieve',
            __('To update') => 'update'
        ];
    }
}
