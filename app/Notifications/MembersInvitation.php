<?php

namespace App\Notifications;

use App\Models\Invite;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class MembersInvitation extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $inviter;
    public function __construct(User $inviter)
    {
        $this->inviter =$inviter;
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


        $token = Invite::where('email', $notifiable->email)->select('token')->first();
        return (new MailMessage)
            ->subject('Invitation to join HubnSub .')
            ->line($this->inviter->user_name.''. '  ('.$this->inviter->email .') '.'invited you to join Portapeole\'s organization on HubnSub.
             It is a great way to organize your workflow and improve communication with your team.')
            ->line('Follow this Link to create your account')
            //todo this url is bad practice make it dynamic url something like base_url in php
//            ->action('Go to setup your account', 'http://196.221.67.81:23007/register-wizard/account?token=' . $token->token)
            ->action('Accept Invite', env('FRONT_END_URL', null) . 'register-wizard/account?token=' . $token->token)
            ->line('Enjoy your time!HubnSub®');

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
