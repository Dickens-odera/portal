<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeanToRegistrarNotification extends Notification
{
    use Queueable;
    /**
     * @var string $email
     */
    public $email;
    /**
     * @var int $application
     */
    public $application;
    /**
     * @var string name
     */
    public $name;
    /**
     * @var string $school
     */
    public $school;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($application, $name, $school)
    {
        //$this->email = $email;
        $this->application = $application;
        $this->name = $name;
        $this->school = $school;
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
                    ->greeting('Hello'.' '.$this->name)
                    ->subject('Transfer Application Approval Request')
                    ->line('You have received a notification from the dean to the'.' '.$this->school.' '.'to act on the following application:')
                    ->line('Application Sr/No: '.$this->application)
                    ->line('Kindly click the buton below to proceed to the applications page.')
                    ->action('Go To Applications Portal', route('registrar.application.single.view',['app_id'=>$this->application]))
                    ->line('In case of any challenges, please contact the system administrator!');
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
