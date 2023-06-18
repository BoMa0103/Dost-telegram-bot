<?php

namespace App\Telegram\Handlers\Message;

use App\Telegram\Senders\CitySender;
use Longman\TelegramBot\Entities\Message;

class CityMessageHandler
{
    /** @var CitySender */
    private $citySender;

    public function __construct(
        CitySender $citySender,
    )
    {
        $this->citySender = $citySender;
    }

    public function handle(Message $message)
    {
        $chatId = $message->getChat()->getId();
        return $this->citySender->send($chatId);
    }
}
