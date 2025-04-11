<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SellerStatusNotification extends Notification
{
    use Queueable;

    protected $status; // Добавляем свойство

    /**
     * Create a new notification instance.
     */
    public function __construct($status) // Добавляем параметр
    {
        $this->status = $status; // Сохраняем статус
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Статус вашей заявки на продавца')
            ->line($this->status == 1 
                ? 'Ваша заявка на продавца была одобрена!'
                : 'К сожалению, ваша заявка на продавца была отклонена.')
            ->action('Перейти в личный кабинет', url('/dashboard'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'status' => $this->status, // Добавляем статус в массив
            'message' => $this->status == 1 
                ? 'Заявка одобрена' 
                : 'Заявка отклонена'
        ];
    }
}