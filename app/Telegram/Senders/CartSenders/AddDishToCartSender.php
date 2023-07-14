<?php

namespace App\Telegram\Senders\CartSenders;

use App\Telegram\Senders\CommonSenders\TelegramSender;

class AddDishToCartSender extends TelegramSender
{
    public function sendDishNotFound(int $chatId)
    {
        $data = [
            'chat_id' => $chatId,
            'text'    => trans('bots.dishNotFound'),
        ];
        return $this->sendData($data);
    }

    public function send(int $chatId)
    {
        $data = [
            'chat_id' => $chatId,
            'text' => trans('bots.dishAddedToCart'),
        ];
        return $this->sendData($data);
    }
}
