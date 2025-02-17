<?php

namespace JustBetter\MagentoPricesNova\Nova\Filters;

use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class Product extends Filter
{
    public function __construct()
    {
        $this->name = __('Product exists in Magento');
    }

    /** @param Builder $query */
    public function apply(NovaRequest $request, EloquentBuilder $query, mixed $value): Builder|EloquentBuilder
    {
        return $query->whereHas('product', function (Builder $query) use ($value): void {
            $query->where('exists_in_magento', '=', $value);
        });
    }

    public function options(NovaRequest $request): array
    {
        return [
            (string) __('Exists in Magento') => 1,
            (string) __('Not in Magento') => 0,
        ];
    }
}
