<?php

namespace App\Telegram\Handlers\CallbackQuery;

use App\Services\Dots\DotsService;
use App\Telegram\Senders\OrderSenders\OrderInfoSender;
use Illuminate\Support\Facades\Log;
use Longman\TelegramBot\Entities\CallbackQuery;

class CheckOrderStatusHandler
{
    public function __construct(
        private readonly OrderInfoSender $orderInfoSender,
        private readonly DotsService $dotsService,
    ){
    }

    public function handle(CallbackQuery $callbackQuery)
    {
        $message = $callbackQuery->getMessage();
        $data = $callbackQuery->getData();
        $data = json_decode($data, true);
        $chatId = $message->getChat()->getId();

        $orderId = $data['id'];
        Log::info('Order info id: ' . $orderId);


        $orderInfo = $this->dotsService->getOrderInfo($orderId);

        Log::info('Order info: ', $orderInfo);

        if(!$orderInfo){
            return $this->orderInfoSender->sendOrderNotCreated($chatId);
        }

        return $this->orderInfoSender->send($chatId, $orderInfo);
    }
}
