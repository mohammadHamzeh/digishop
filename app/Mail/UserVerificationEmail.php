<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class UserVerificationEmail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var User
     */
    private $user;

    /**
     * Create a new message instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Email Verification')->markdown('mails.verification-email')->with([
            'url' => $this->generateUrl()
        ]);
    }

    private function generateUrl()
    {
        return URL::temporarySignedRoute('verification.verify', now()->addMinutes(120), [
            'id' => $this->user->getKey(),
            'hash' => sha1($this->user->getEmailForVerification())
        ]);
    }
}
