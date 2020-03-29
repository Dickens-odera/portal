<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CODNewAccountCreatedNotification extends Notification
{
    use Queueable;
    /**
     * @var string $password
     */
    public $password;
    /**
     * @var string $email
     */
    public $email;
    /**
     * @var string $department
     */
    public $department;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($email, $password, $department)
    {
        $this->email = $email;
        $this->password = $password;
        $this->department = $department;
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
                    ->greeting('Hello There!')
                    ->subject('Your Account Login Credentials')
                    ->line('You have been added by our system administrator as a chairperson to the'.' '.$this->department.' '.'department')
                    ->line('Kindly use these credentials to log into your new account.')
                    ->line('Email: '.' '.$this->email)
                    ->line('Password: '.' '.$this->password)
                    ->action('Go To Account', route('cod.login'))
                    ->line('For security purposes, we recommend that you change your password after loggin in.')
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
