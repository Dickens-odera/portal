<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CodToDeanNotificationOnOutgoingApplication extends Notification
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
     * @var string $department
     */
    public $department;
    /**
     * @var string $application
     */
    public $application;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name, $email, $department, $application)
    {
        $this->name = $name;
        $this->email = $email;
        $this->department = $department;
        $this->application = $application;
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
                    ->greeting('Hello!'.' '.$this->name)
                    ->subject('Transfer Application Request for Approval')
                    ->line('You have reveived a request from the COD to the '.' '.$this->department.' '.'department to act on to application serial no:'.' '.$this->application)
                    ->line('Please click the button bellow to check the application')
                    ->action('Go To My Portal', route('dean.application.outgoing.view',['app_id'=>$this->application]))
                    ->line('Incase of any challenges, please contact the system administrator!');
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
