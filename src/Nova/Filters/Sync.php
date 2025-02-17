<?php

namespace JustBetter\MagentoPricesNova\Nova\Filters;

use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class Sync extends Filter
{
    public function __construct()
    {
        $this->name = __('Price sync');
    }

    /** @param Builder $query */
    public function apply(NovaRequest $request, EloquentBuilder $query, mixed $value): Builder|EloquentBuilder
    {
        return $query->where('sync', '=', $value);
    }

    public function options(NovaRequest $request): array
    {
        return [
            (string) __('In sync') => 1,
            (string) __('Not in sync') => 0,
        ];
    }
}
