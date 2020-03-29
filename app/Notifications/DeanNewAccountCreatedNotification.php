<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeanNewAccountCreatedNotification extends Notification
{
    use Queueable;
    /**
     * @var $email
     */
    public $email;
    /**
     * @var $password
     */
    public $password;
    /**
     * @var string $school
     */
    public $school;
    /**
     * @var string $name
     */
    public $name;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($email, $password, $school,$name)
    {
        $this->email = $email;
        $this->password = $password;
        $this->school = $school;
        $this->name = $name;
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
                    ->greeting('Hello '.' '.$this->name.'!')
                    ->subject('Your Account Login Credentials')
                    ->line('You have been added by our system administrator as a dean to the'.' '.$this->school)
                    ->line('Kindly Use these Credentials to log into your new account')
                    ->line('You can change your password after loging in')
                    ->line("Email:"." ".$this->email)
                    ->line('Password: '.' '.$this->password)
                    ->action('Go To Account', route('dean.login'))
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
