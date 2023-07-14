<?php

namespace App\Telegram\Handlers\Message;

use App\Services\Cart\CartService;
use App\Telegram\Resolvers\TelegramMessageCartResolver;
use App\Telegram\Senders\CartSenders\CartSender;
use App\Telegram\Senders\DishSenders\DishCategorySender;
use Longman\TelegramBot\Entities\Message;

class DishCategoryMessageHandler
{

    public function __construct(
        private readonly DishCategorySender $dishCategorySender,
        private readonly CartSender $cartSender,
        private readonly TelegramMessageCartResolver $telegramMessageCartResolver,
        private readonly CartService $cartService,
    )
    {
    }

    public function handle(Message $message)
    {
        $chatId = $message->getChat()->getId();
        $cart = $this->telegramMessageCartResolver->resolve($message);
        $companyId = $cart->getCompanyId();

        return $this->dishCategorySender->send($chatId, $companyId);
    }

}
