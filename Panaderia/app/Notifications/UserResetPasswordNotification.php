<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;

class UserResetPasswordNotification extends ResetPasswordNotification
{
    use Queueable;

    protected $user;
    protected $so;
    protected $browser;


    /**
     * Set the user of notification.
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * Set the client so of notification.
     * @param $so
     */
    public function setSo($so)
    {
        $this->so = $so;
    }

    /**
     * Set the client browser of notification.
     * @param $browser
     */
    public function setBrowser($browser)
    {
        $this->browser = $browser;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        return (new MailMessage)
            ->subject('Recupera tu Contraseña')
            ->view(['mails.portal.reset_password', 'mails.portal.reset_password_plain'],
                [
                    'name' => $this->user->name,
                    'confirm_url' => url('password/reset', $this->token),
                    'so' => $this->so,
                    'browser' => $this->browser,
                    'support_email' => config('app.support_email')
                ]
            );
    }

}
