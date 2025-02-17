<?php

namespace JustBetter\MagentoPricesNova\Nova\Filters;

use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class Status extends Filter
{
    public function __construct()
    {
        $this->name = __('Price status');
    }

    /** @param Builder $query */
    public function apply(NovaRequest $request, EloquentBuilder $query, mixed $value): Builder|EloquentBuilder
    {
        return $query->where($value, true);
    }

    public function options(NovaRequest $request): array
    {
        return [
            (string) __('To retrieve') => 'retrieve',
            (string) __('To update') => 'update',
        ];
    }
}
