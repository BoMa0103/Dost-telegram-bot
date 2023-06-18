<?php

namespace App\Telegram\Handlers\CallbackQuery;

use App\Services\Cart\Repositories\CartRepositoryInterface;
use App\Telegram\Resolvers\TelegramMessageCartResolver;
use App\Telegram\Senders\CartSender;
use Longman\TelegramBot\Entities\CallbackQuery;

class ClearCartCallbackHandler
{
    /** @var CartSender */
    private $cartSender;
    /** @var CartRepositoryInterface */
    private $cartRepository;
    /** @var TelegramMessageCartResolver */
    private $telegramMessageCartResolver;

    public function __construct(
        CartSender $cartSender,
        CartRepositoryInterface $cartRepository,
        TelegramMessageCartResolver $telegramMessageCartResolver,
    )
    {
        $this->cartSender = $cartSender;
        $this->cartRepository = $cartRepository;
        $this->telegramMessageCartResolver = $telegramMessageCartResolver;
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
