<?php

namespace App\Telegram\Handlers\Message;

use App\Services\Cart\CartService;
use App\Telegram\Resolvers\TelegramMessageCartResolver;
use App\Telegram\Senders\OrderSenders\RequestAddressSender;
use Longman\TelegramBot\Entities\Message;

class StreetAddressHandler
{
    public function __construct(
        private readonly TelegramMessageCartResolver $telegramMessageCartResolver,
        private readonly CartService $cartService,
        private readonly RequestAddressSender $requestAddressSender,
    )
    {
    }

    public function handle(Message $message)
    {
        $chatId = $message->getChat()->getId();
        $cart = $this->telegramMessageCartResolver->resolve($message);
        $this->cartService->setDeliveryAddressStreet($cart, $message->getText());

        return $this->requestAddressSender->sendHouse($chatId);
    }
}
