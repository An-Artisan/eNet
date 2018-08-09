<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DataServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'App\Interfaces\UserInterface',
            'App\Repositories\UserRepository'
        );
        $this->app->bind(
            'App\Interfaces\SupplierInterface',
            'App\Repositories\SupplierRepository'
        );
        $this->app->bind(
            'App\Interfaces\OrderInterface',
            'App\Repositories\OrderRepository'
        );
        $this->app->bind(
            'App\Interfaces\DistributionInterface',
            'App\Repositories\DistributionRepository'
        );
        $this->app->bind(
            'App\Interfaces\GoodsInterface',
            'App\Repositories\GoodsRepository'
        );
        $this->app->bind(
            'App\Interfaces\GoodsTypeInterface',
            'App\Repositories\GoodsTypeRepository'
        );

        $this->app->bind(
            'App\Interfaces\GoodsTypeSecondInterface',
            'App\Repositories\GoodsTypeSecondRepository'
        );
        $this->app->bind(
            'App\Interfaces\TransportInterface',
            'App\Repositories\TransportRepository'
        );

        $this->app->bind(
            'App\Interfaces\RedPacketInterface',
            'App\Repositories\RedPacketRepository'
        );

        $this->app->bind(
            'App\Interfaces\ShoppingCartInterface',
            'App\Repositories\ShoppingCartRepository'
        );

        $this->app->bind(
            'App\Interfaces\MarketInterface',
            'App\Repositories\MarketRepository'
        );


        $this->app->bind(
            'App\Interfaces\FrequentlyQuestionInterface',
            'App\Repositories\FrequentlyQuestionRepository'
        );
        $this->app->bind(
            'App\Interfaces\NewQuestionInterface',
            'App\Repositories\NewQuestionRepository'
        );
        $this->app->bind(
            'App\Interfaces\BannerInterface',
            'App\Repositories\BannerRepository'
        );
        $this->app->bind(
            'App\Interfaces\DataStatisticsInterface',
            'App\Repositories\DataStatisticsRepository'
        );
    }

    public function boot()
    {
    }
}
