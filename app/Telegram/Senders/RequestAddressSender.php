<?php

namespace App\Telegram\Senders;

class RequestAddressSender extends TelegramSender
{
    public function sendStreet(int $chatId)
    {
        $data = [
            'chat_id' => $chatId,
            'text' => trans('bots.enterYourAddressStreet'),
        ];
        return $this->sendData($data);
    }

    public function sendHouse(int $chatId)
    {
        $data = [
            'chat_id' => $chatId,
            'text' => trans('bots.enterYourAddressHouse'),
        ];
        return $this->sendData($data);
    }
}
