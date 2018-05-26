<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class resetGeneratePassword extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $userName;
    public function __construct($userName)
    {
        $this->userName = $userName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $generatedPassword = $notifiable->password;
        DB::table('users')->where('id', $notifiable->id)->update(['password' => bcrypt($notifiable->password)]);

        return (new MailMessage)
            ->greeting('Hello '.$this->userName.' !')
            ->subject('ResetPassword email')
            ->line('Password reset request')
            ->line('Here\'s your new password" ')
            ->action($generatedPassword, url(''))
//            ->view('vendor/notifications/resetGeneratedPassword', compact('generatedPassword'))
            ->line('We’ve received a request from your hubnSub Account to reset
             its Password. Please use the password above to log into your account.')
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
