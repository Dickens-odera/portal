<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StudentAccountCreatedNotification extends Notification
{
    use Queueable;

    /**
     * @var string $name
     */
    public $name;
    /**
     * @var string $email
     */
    public $email;
    /**
     * @var string $password
     */
    public $password;
    /**
     * Create a new notification instance.
     *
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
                    ->greeting('Hello!',' '.$this->name)
                    ->subject('Account Login Credentials')
                    ->line('Thank you for registering with us. Kindly use these credentials to login to  your account')
                    ->line('Email: '.' '.$this->email)
                    ->line('Password: '.' '.$this->password)
                    ->action('Clik Here to Login', route('student.login'))
                    ->line('For security purposes, we highly recommend that you that you change your password after login in')
                    ->line('We wish you all the best!');
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
