<?php

namespace App\Models;

use App\Jobs\SendEmail;
use App\Mail\UserResetPassword;
use App\Mail\UserVerificationEmail;
use App\Models\Shop\Cart;
use App\Support\Discount\Traits\Couponable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, Couponable;
    const USER = 1;
    const EDITOR = 2;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute()
    {
        return $this->attributes['name'] . ' ' . $this->attributes['family'];
    }

    public function user_data()
    {
        return $this->hasOne(User::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function sendPasswordResetNotification($token)
    {
        SendEmail::dispatch($this, new UserResetPassword($this, $token));
    }

    public function sendEmailVerificationNotification()
    {
        SendEmail::dispatch($this, new UserVerificationEmail($this));
    }
    

}
