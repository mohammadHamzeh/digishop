<?php


namespace App\Services\Notification\Provider;


use App\Models\User;
use App\Services\Notification\Provider\Contracts\Provider;

class SmsProvider implements Provider
{
    /**
     * @var User
     */
    private $user;
    private $string;

    public function __construct(User $user, $string)
    {
        $this->user = $user;
        $this->string = $string;
    }

    public function send()
    {
        $phone_number = $this->getMobile();
        /*todo send Sms*/
    }

    private function getMobile()
    {
        if ($this->user->phone == null) {
            throw new \Exception('The User Mobile null');
        }
    }
}
