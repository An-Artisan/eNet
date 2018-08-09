<?php

namespace App\Listeners;

use App\Events\LevelUpdate;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\LevelCreditUpdatedEvent;
use App\Models\UserLevel;
use App\User;
use Log;

class LevelCreditUpdatedListener
{
    public $connection = 'redis';
    public $queue = 'LevelCreditUpdatedListener';

    protected $level;
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
     * @param  LevelUpdate  $event
     * @return void
     */
    public function handle(LevelCreditUpdatedEvent $event)
    {
        $this->level = $event->level;

        // 删除之前属于该等级的用户
        UserLevel::where('level_id', $this->level->id)->delete();

        // 重新设置用户等级
        User::whereHas('userExtra', function ($query) {
            $query->whereBetween('credit', [$this->level->credit_lower_limit, $this->level->credit_upper_limit]);
        })
        ->each(function ($user) {
            $user->level()->attach($this->level->id);
        });
    }
}
