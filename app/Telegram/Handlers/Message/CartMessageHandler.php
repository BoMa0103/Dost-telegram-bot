<?php

namespace App\Telegram\Handlers\Message;

use App\Telegram\Resolvers\TelegramMessageCartResolver;
use App\Telegram\Senders\CartSender;
use Longman\TelegramBot\Entities\Message;

class CartMessageHandler
{
    /** @var TelegramMessageCartResolver */
    private $telegramMessageCartResolver;
    /** @var CartSender */
    private $cartSender;

    public function __construct(
        TelegramMessageCartResolver $telegramMessageCartResolver,
        CartSender $cartSender,
    )
    {
        $this->telegramMessageCartResolver = $telegramMessageCartResolver;
        $this->cartSender = $cartSender;
    }

    public function handle(Message $message)
    {
        $cart = $this->telegramMessageCartResolver->resolve($message);

        $chatId = $message->getChat()->getId();

        return $this->cartSender->sendCart($chatId, $cart);
    }
}
