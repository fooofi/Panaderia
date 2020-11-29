<?php

namespace App\Mail;

use App\Models\FairUser;
use App\Models\FairUserEmailVerification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FairUserConfirmMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $confirm_url;

    /**
     * Create a new message instance.
     *
     * @param FairUser $user
     */
    public function __construct(FairUser $user)
    {
        $this->user = $user;
        $this->confirm_url = config('app.fair_verification_url') . "?token=" . $user->fair_user_email_verification->token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->subject('Bienvenido a MundoTES')->view('mails.fair.user_confirm', [
            'name' => $this->user->name,
            'confirm_url' => $this->confirm_url,
            'username' => $this->user->email,
            'support_email' => config('app.support_email'),
            'ttl' => config('app.fair_verification_ttl')
        ])->text('mails.fair.user_confirm_plain', [
            'name' => $this->user->name,
            'confirm_url' => $this->confirm_url,
            'username' => $this->user->email,
            'support_email' => config('app.support_email')
        ]);
    }
}
