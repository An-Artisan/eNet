<?php

namespace App\Listeners;

use App\Events\UserUpgradeToMinerEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Repositories\MineRepository;

class UserUpgradeToMinerListener
{
    protected $user;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserUpgradeToMinerEvent  $event
     * @return void
     */
    public function handle(UserUpgradeToMinerEvent $event)
    {
        $this->user = $event->user;

        // 用户升级为矿工
        $miner = MineRepository::upgradeToMiner($this->user);

        // 发放用户初次挖矿的奖励
        MineRepository::issueInitialMineral($miner);
    }
}
