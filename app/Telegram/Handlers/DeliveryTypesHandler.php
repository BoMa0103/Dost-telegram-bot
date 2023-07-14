<?php

namespace App\Telegram\Handlers;

use App\Telegram\Senders\OrderSenders\DeliveryTypesSender;
use Longman\TelegramBot\Entities\Message;

class DeliveryTypesHandler
{
    public function __construct(
        private readonly DeliveryTypesSender $deliveryTypesSender,
    )
    {
    }

    /**
     * @param Message $message
     * @return Message
     */
    public function handle(Message $message)
    {
        return $this->deliveryTypesSender->send($message->getFrom()->getId());
    }
}
