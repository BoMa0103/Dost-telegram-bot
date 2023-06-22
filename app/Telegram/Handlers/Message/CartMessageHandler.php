<?php

namespace App\Telegram\Handlers\Message;

use App\Telegram\Resolvers\TelegramMessageCartResolver;
use App\Telegram\Senders\CartSender;
use Longman\TelegramBot\Entities\Message;

class CartMessageHandler
{

    public function __construct(
        private readonly TelegramMessageCartResolver $telegramMessageCartResolver,
        private readonly CartSender $cartSender,
    )
    {
    }

    public function handle(Message $message)
    {
        $cart = $this->telegramMessageCartResolver->resolve($message);

        $chatId = $message->getChat()->getId();

        return $this->cartSender->sendCart($chatId, $cart);
    }
}
