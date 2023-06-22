<?php

namespace App\Telegram\Handlers\Message;

use App\Telegram\Senders\CitySender;
use Longman\TelegramBot\Entities\Message;

class CityMessageHandler
{

    public function __construct(
        private readonly CitySender $citySender,
    )
    {
    }

    public function handle(Message $message)
    {
        $chatId = $message->getChat()->getId();
        return $this->citySender->send($chatId);
    }
}
