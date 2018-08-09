<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        // 用户等级配置-发生更改
        'App\Events\LevelCreditUpdatedEvent' => [
            'App\Listeners\LevelCreditUpdatedListener'
        ],
        // 用户升级为矿工
        'App\Events\UserUpgradeToMinerEvent' => [
            'App\Listeners\UserUpgradeToMinerListener'
        ],
        // 挖矿工单-状态发生变化
        'App\Events\MineOrderStatusUpdatedEvent' => [
            'App\Listeners\MineOrderStatusUpdatedListener'
        ],
        // 日志-创建
        'App\Events\LogCreatedEvent' => [
            'App\Listeners\LogCreatedListener'
        ],
        // 访问令牌创建
        'Laravel\Passport\Events\AccessTokenCreated' => [
            'App\Listeners\RevokeOldTokens',
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
