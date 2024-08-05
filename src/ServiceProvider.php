<?php

namespace JustBetter\MagentoPricesNova;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use JustBetter\MagentoPricesNova\Nova\PriceResource;
use Laravel\Nova\Nova;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        Nova::serving(function (): void {
            Nova::resources([
                PriceResource::class,
            ]);
        });
    }
}
