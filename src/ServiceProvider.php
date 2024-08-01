<?php

namespace JustBetter\MagentoPricesNova;

use JustBetter\MagentoPricesNova\Nova\Prices;
use Laravel\Nova\Nova;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        Nova::resources([
            Prices::class,
        ]);
    }
}
