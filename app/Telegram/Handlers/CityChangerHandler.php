<?php

namespace App\Telegram\Handlers;

use App\Services\Cart\Repositories\CartRepositoryInterface;
use App\Telegram\Resolvers\TelegramMessageCartResolver;
use App\Telegram\Senders\CartSender;
use Longman\TelegramBot\Entities\CallbackQuery;

class CityChangerHandler
{
    public function __construct(
        private readonly CartSender $cartSender,
        private readonly CartRepositoryInterface $cartRepository,
        private readonly TelegramMessageCartResolver $telegramMessageCartResolver,
    )
    {
    }

    public function handle(CallbackQuery $callbackQuery)
    {
        $chatId = $callbackQuery->getMessage()->getChat()->getId();
        $message = $callbackQuery->getMessage();
        $data = $callbackQuery->getData();
        $data = json_decode($data, true);
        $answer = $data['value'];

        $cart = $this->telegramMessageCartResolver->resolve($message);

        if($answer == 'yes'){
            $this->cartRepository->clearItems($cart);
            $this->cartRepository->clearCity($cart);
            $this->cartRepository->clearCompany($cart);
            return $this->cartSender->sendChangeCitySuccessful($chatId);
        }
    }
}
