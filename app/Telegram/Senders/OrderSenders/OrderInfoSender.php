<?php

namespace App\Telegram\Senders\OrderSenders;

use App\Telegram\Senders\CommonSenders\TelegramSender;
use Illuminate\Support\Facades\Log;

class OrderInfoSender extends TelegramSender
{
    public function send(int $chatId, array $orderInfo)
    {
        Log::info('Order info: ', $orderInfo);

        $data = [
            'chat_id' => $chatId,
            'text'    => trans('bots.yourOrderSuccessfullyCreated') . $orderInfo['number'],
        ];
        return $this->sendData($data);
    }

    public function sendOrderNotCreated(int $chatId)
    {
        $data = [
            'chat_id' => $chatId,
            'text'    => trans('bots.yourOrderNotCreated'),
        ];
        return $this->sendData($data);
    }
}
