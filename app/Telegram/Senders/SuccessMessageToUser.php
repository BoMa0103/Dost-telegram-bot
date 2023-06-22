<?php

namespace App\Telegram\Senders;

use Illuminate\Support\Facades\Log;
use Longman\TelegramBot\Entities\InlineKeyboard;

class SuccessMessageToUser extends TelegramSender
{
    public function send(int $chatId, string $text, string $orderId)
    {
        $inlineKeyboard = $this->getOrderStatusKeyboard($orderId);
        $data = [
            'chat_id' => $chatId,
            'text' => $text,
            'reply_markup' => $inlineKeyboard,
        ];
        return $this->sendData($data);
    }

    /**
     * @return InlineKeyboard
     */
    private function getOrderStatusKeyboard(string $orderId): InlineKeyboard
    {
        $items[] = [
            [
                'text' => trans('bots.checkOrderStatus'),
                'callback_data' => '{"type":"status","id":"' . $orderId . '"}',
            ]
        ];
        $keyboard = new InlineKeyboard(...$items);
        return $keyboard
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true)
            ->setSelective(false);
    }
}
