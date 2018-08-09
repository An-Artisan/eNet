<?php

namespace App\Listeners;

use App\Events\LogCreatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Log\Log;
use App\User;
use Carbon\Carbon;
use App\Repositories\UserRepository;

class LogCreatedListener
{
    protected $log;
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
     * @param  LogCreatedEvent  $event
     * @return void
     */
    public function handle(LogCreatedEvent $event)
    {
        $this->log = $event->log;

        switch ($this->log->action) {
            // 当日志类型为“登录”时，增加用户积分
            case Log::ACTION_LOGIN:
                $user = $this->log->user;
                $logs = $user->whereDoesntHave('creditFlows', function ($query) {
                    $query->where('credit_flow_type', Log::ACTION_LOGIN)
                    ->whereDate('created_at', Carbon::now()->toDateString());
                })->get();
                
                $sumCredit = intval(UserRepository::getUserSumCredit($user));
                $growthHashrateUpperLimit = intval(get_system_config('growth_hashrate_upper_limit'));
                if ($logs->count() && ($growthHashrateUpperLimit == 0 || $sumCredit < $growthHashrateUpperLimit)) {
                    UserRepository::awardUserCredit($user, get_system_config('mine_hashrate_growth_value'), __('user-credit-flow.award.login'));
                }
                
                break;

            // 当日志类型为“注册”时，增加用户积分
            case Log::ACTION_REGISTER:
                $user = $this->log->user;
                UserRepository::awardUserCredit($user, get_system_config('init_hashrate'), __('user-credit-flow.award.register'));
                
                break;
            
            default:
                # nothing
                break;
        }
    }
}
