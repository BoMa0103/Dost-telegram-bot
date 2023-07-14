<?php

namespace App\Telegram\Handlers\CallbackQuery;

use App\Services\Cart\CartService;
use App\Services\Dots\DTO\UserDTO;
use App\Telegram\Resolvers\TelegramMessageCartResolver;
use App\Telegram\Senders\OrderSenders\RequestAddressSender;
use Longman\TelegramBot\Entities\CallbackQuery;

class DeliveryToDoorHandler
{
    public function __construct(
        private readonly RequestAddressSender $requestAddressSender,
        private readonly TelegramMessageCartResolver $telegramMessageCartResolver,
        private readonly CartService $cartService,
    )
    {
    }

    public function handle(CallbackQuery $callbackQuery)
    {
        $message = $callbackQuery->getMessage();

        $cart = $this->telegramMessageCartResolver->resolve($message);

        $this->cartService->setDeliveryType($cart, UserDTO::DELIVERY_TO_DOOR);

        $chatId = $message->getChat()->getId();

        return $this->requestAddressSender->sendStreet($chatId);
    }
}
