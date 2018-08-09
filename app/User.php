<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Models\Language;
use App\Notifications\ResetPassword as RestPasswordNotification;

class User extends Authenticatable
{

    use HasApiTokens,EntrustUserTrait,Notifiable ;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'username', 'nickname','phone', 'email', 'photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    public function findForPassport($login)
    {
        return $this->orWhere('openid', $login)
            ->orWhere('phone', $login)
            ->orWhere('username', $login)
            ->first();
    }



}
