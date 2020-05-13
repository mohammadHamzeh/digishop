<?php


namespace App\Services\Notification\Constants;


use App\Mail\UserRegistered;
use App\Mail\UserResetPassword;

class EmailTypes
{
    const USER_REGISTERED = 1;
    const FORGET_PASSWORD = 2;

    public static function toString()
    {
        return [
            self::USER_REGISTERED => 'ثبت نام کاربر',
            self::FORGET_PASSWORD => 'فراموشی رمز عبور'
        ];
    }

    public static function toMail($type)
    {
        try {
            return [
                self::USER_REGISTERED => UserRegistered::class,
                self::FORGET_PASSWORD => UserResetPassword::class
            ][$type];
        } catch (\Throwable $e) {
            throw new \InvalidArgumentException('Mailable class does not exist');
        }
    }
}
