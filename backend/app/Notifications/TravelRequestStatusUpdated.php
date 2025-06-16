<?php

namespace App\Notifications;

use App\Models\TravelRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TravelRequestStatusUpdated extends Notification
{
    public TravelRequest $travelRequest;

    public function __construct(TravelRequest $travelRequest)
    {
        $this->travelRequest = $travelRequest;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('O status da sua solicitação de viagem foi atualizado')
            ->greeting('Olá ' . $notifiable->name . ',')
            ->line('O status da sua solicitação de viagem para ' . $this->travelRequest->destination . ' foi atualizado para: ' . $this->travelRequest->status . '.')
            ->line('Data de partida: ' . $this->travelRequest->departure_date)
            ->line('Data de retorno: ' . $this->travelRequest->return_date);
    }

    public function toArray($notifiable)
    {
        return [
            'request_id' => $this->travelRequest->id,
            'status' => $this->travelRequest->status,
        ];
    }
}
