<?php

namespace App\Notifications;

use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class ConfirmationCode extends Notification implements ShouldQueue
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
        $confirmationCode = str_random(6);
        $exist = DB::table('confirmation_codes')->where('user_id', $notifiable->id)->first();
        if (!$exist) {
            DB::table('confirmation_codes')->insert([
                'user_id' => $notifiable->id,
                'code' => $confirmationCode,
                'created_at' => Carbon::now('africa/cairo')
            ]);
        } else {
            DB::table('confirmation_codes')->where('user_id', $notifiable->id)->update([
                'code' => $confirmationCode,
                'updated_at' => Carbon::now('africa/cairo')
            ]);
        }
        return (new MailMessage)
            ->greeting('Hello '.$this->userName.' !')
            ->subject('Verification email')
            ->line('HubnSub Account Verification.')
            ->line('Here’s your verification code:')
            ->action($confirmationCode,'')
//            ->view('vendor/notifications/confirmation-code', compact('confirmationCode'))
            ->line('Thank you for joiningHubnSub. Please use the code above to verify ownership of your account.')
            ->line('Note: The code will expire in 10 minutes, so please verify soon!')
            ->line('Enjoy your time!')
            ->line('HubnSub®')
            ;
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
