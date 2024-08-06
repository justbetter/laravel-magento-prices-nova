<?php

namespace JustBetter\MagentoPricesNova\Nova;

use Bolechen\NovaActivitylog\Resources\Activitylog;
use Illuminate\Http\Request;
use JustBetter\MagentoPrices\Models\Price;
use JustBetter\MagentoProducts\Models\MagentoProduct;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;

class PriceResource extends Resource
{
    public static string $model = Price::class;

    public static $title = 'sku';

    public static $group = 'prices';

    public static $search = [
        'sku',
    ];

    public static function label(): string
    {
        return __('Prices');
    }

    public static function uriKey(): string
    {
        return 'magento-prices';
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Boolean::make(__('Keep in sync'), 'sync')
                ->help(__('Disable if this product stock should not be synced'))
                ->sortable(),

            Boolean::make(__('Exists in Magento'), function (Price $price): bool {
                $product = MagentoProduct::findBySku($price->sku);

                return $product === null ? false : $product->exists_in_magento;
            })
                ->showOnIndex(false),

            Text::make(__('SKU'), 'sku')
                ->readonly()
                ->sortable(),

            Code::make(__('Base prices'), 'base_prices')
                ->json()
                ->readonly(),

            Code::make(__('Tier prices'), 'tier_prices')
                ->json()
                ->readonly(),

            Code::make(__('Special prices'), 'special_prices')
                ->json()
                ->readonly(),

            Boolean::make(__('Retrieve'), 'retrieve')
                ->help(__('Automatically set to true if this product should be retrieved'))
                ->sortable(),

            Boolean::make(__('Update'), 'update')
                ->help(__('Automatically set to true if this product should be updated in Magento'))
                ->sortable(),

            DateTime::make(__('Last retrieved'), 'last_retrieved')
                ->readonly()
                ->sortable(),

            DateTime::make(__('Last updated'), 'last_updated')
                ->readonly()
                ->sortable(),

            DateTime::make(__('Last failed'), 'last_failed')
                ->readonly()
                ->sortable(),

            Number::make(__('Fail count'), 'fail_count')
                ->readonly()
                ->onlyOnDetail(),

            MorphMany::make(__('Activity'), 'activities', Activitylog::class),
        ];
    }

    public function actions(NovaRequest $request): array
    {
        return [
            Actions\RetrievePrice::make(),
            Actions\RetrieveAllPrices::make(),
            Actions\UpdatePrice::make(),
            Actions\ResetFailures::make(),
            Actions\ProcessProductsWithMissingPrices::make(),
        ];
    }

    public function cards(NovaRequest $request): array
    {
        return [
            Metrics\PricesToRetrieve::make(),
            Metrics\PricesToUpdate::make(),
            Metrics\PricesSyncPartition::make(),
            Metrics\PriceRetrievalsPerDay::make(),
            Metrics\PriceUpdatesPerDay::make(),
            Metrics\PriceErrorsPerDay::make(),
        ];
    }

    public function filters(NovaRequest $request): array
    {
        return [
            Filters\Status::make(),
            Filters\Failed::make(),
            Filters\Sync::make(),
            Filters\Product::make(),
        ];
    }

    public static function authorizedToCreate(Request $request): bool
    {
        return false;
    }

    public function authorizedToReplicate(Request $request): bool
    {
        return false;
    }
}
