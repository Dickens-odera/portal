<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class newRegistrarAccountCreated extends Notification
{
    use Queueable;
    /**
     * @var string $name;
     */
    public $name;
    /**
     * @var string $email
     */
    public $emai;
    /**
     * @var string $password
     */
    public $password;
    /**
     * Create a new notification instance.
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @return void
     */
    public function __construct($name, $email, $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                    ->greeting('Hello there'.' '.$this->name.' '.'!')
                    ->subject('Account Login Credentials')
                    ->line('You have been added by our system administrator as the registrar, Academic Affairs')
                    ->line('Kindly use the credentials bellow to login to the portal')
                    ->line('Email:'.' '.$this->email)
                    ->line('Password:'.' '.$this->password)
                    ->action('Go To Account', route('registrar.login'))
                    ->line('For security purposes, we highly recommend that you change your password after loggin in')
                    ->line('Cheers!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
