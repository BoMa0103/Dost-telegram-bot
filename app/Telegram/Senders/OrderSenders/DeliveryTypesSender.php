<?php

namespace App\Telegram\Senders\OrderSenders;

use App\Services\Dots\DotsService;
use App\Telegram\Senders\CommonSenders\TelegramSender;
use Longman\TelegramBot\Entities\InlineKeyboard;

class DeliveryTypesSender extends TelegramSender
{
    /** @var DotsService */
    private $dotsService;

    public function __construct(
        DotsService $dotsService
    )
    {
        $this->dotsService = $dotsService;
    }

    public function send(int $chatId)
    {
        $data = [
            'chat_id' => $chatId,
            'text' => trans('bots.chooseDeliveryType'),
            'reply_markup' => $this->getDeliveryTypes(),
        ];
        return $this->sendData($data);
    }

    /**
     * @return InlineKeyboard
     */
    private function getDeliveryTypes(): InlineKeyboard
    {
        $items[] = [
            [
                'text' => trans('bots.deliveryToDoor'),
                'callback_data' => '{"type": "deliveryToDoor"}',
            ]
        ];
        $items[] = [
            [
                'text' => trans('bots.deliveryToFlat'),
                'callback_data' => '{"type": "deliveryToFlat"}',
            ]
        ];
        $items[] = [
            [
                'text' => trans('bots.pickup'),
                'callback_data' => '{"type": "pickup"}',
            ]
        ];
        $keyboard = new InlineKeyboard(...$items);
        return $keyboard
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true)
            ->setSelective(false);
    }
}
