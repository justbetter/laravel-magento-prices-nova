<?php

namespace JustBetter\MagentoPricesNova\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class Failed extends Filter
{
    /** @param  Builder  $query */
    public function apply(NovaRequest $request, $query, $value): Builder
    {
        return match ($value) {
            'day' => $query->whereDate('last_failed', '>=', now()->startOfDay()),
            'week' => $query->whereDate('last_failed', '>=', now()->subWeek()->startOfDay()),
            'all' => $query->whereNotNull('last_failed'),
        };
    }

    public function options(NovaRequest $request): array
    {
        return [
            __('Past day') => 'day',
            __('Past week') => 'week',
            __('All') => 'all'
        ];
    }
}
