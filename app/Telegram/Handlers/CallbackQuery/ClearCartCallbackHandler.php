<?php

namespace App\Telegram\Handlers\CallbackQuery;

use App\Services\Cart\Repositories\CartRepository;
use App\Telegram\Resolvers\TelegramMessageCartResolver;
use App\Telegram\Senders\CartSenders\CartSender;
use Longman\TelegramBot\Entities\CallbackQuery;

class ClearCartCallbackHandler
{
    public function __construct(
        private readonly CartSender                  $cartSender,
        private readonly CartRepository              $cartRepository,
        private readonly TelegramMessageCartResolver $telegramMessageCartResolver,
    )
    {
    }

    public function handle(CallbackQuery $callbackQuery)
    {
        $chatId = $callbackQuery->getMessage()->getChat()->getId();
        $message = $callbackQuery->getMessage();

        $cart = $this->telegramMessageCartResolver->resolve($message);

        $this->cartRepository->clearItems($cart);
        return $this->cartSender->sendCartClearSuccessful($chatId);
    }
}
