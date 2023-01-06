<?php

namespace App\Containers\AppSection\Notification\Notifications;

use App\Ship\Parents\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use JetBrains\PhpStorm\ArrayShape;

class NotifyUserNotification extends Notification
{

    protected string $rType;
    protected string $context;
    protected array $config;
    protected array $data;

    public function __construct($rType, $context, $config, $data)
    {
        $this->rType = $rType;
        $this->context = $context;
        $this->config = $config;
        $this->data = $data;
    }

   public function toArray($notifiable): array
    {
        return [
            'subject' => $this->config['subject'],
        ];
    }

    public function toMail($notifiable): MailMessage
    {
        $vars = isset($this->data['vars']) ? $this->data['vars'] : [];
        return (new MailMessage())->subject($this->config['subject'])
            ->view('appSection@notification::' . $this->rType . '.' . $this->context, $vars)->with($notifiable);
    }
}
