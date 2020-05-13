<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\Notification\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var User
     */
    private $user;
    private $string;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param $string
     */
    public function __construct(User $user, $string)
    {
        $this->user = $user;
        $this->string = $string;
    }

    /**
     * Execute the job.
     *
     * @param Notification $notification
     * @return void
     */
    public function handle(Notification $notification)
    {
        return $notification->sendSms($this->user, $this->string);
    }
}
