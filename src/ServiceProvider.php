<?php

namespace JustBetter\MagentoPricesNova;

use JustBetter\MagentoPricesNova\Nova\MagentoPrices;
use Laravel\Nova\Nova;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        Nova::resources([
            MagentoPrices::class,
        ]);
    }
}
