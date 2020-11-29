<?php

namespace App\Mail;

use App\Models\FairUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FairUserResetPasswordMail extends Mailable
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
        $this->confirm_url = config('app.fair_password_url') . "?token=" . $user->fair_user_reset_password->token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Recupera tu Contraseña')->view('mails.fair.reset_password', [
            'name' => $this->user->name,
            'confirm_url' => $this->confirm_url,
            'so' => $this->user->fair_user_reset_password->so,
            'browser' => $this->user->fair_user_reset_password->browser,
            'ip' => $this->user->fair_user_reset_password->ip,
            'support_email' => config('app.support_email'),
            'ttl' => config('app.fair_verification_ttl')
        ])->text('mails.fair.reset_password_plain', [
            'name' => $this->user->name,
            'confirm_url' => $this->confirm_url,
            'so' => $this->user->fair_user_reset_password->so,
            'browser' => $this->user->fair_user_reset_password->browser,
            'ip' => $this->user->fair_user_reset_password->ip,
            'support_email' => config('app.support_email'),
            'ttl' => config('app.fair_verification_ttl')
        ]);
    }
}
