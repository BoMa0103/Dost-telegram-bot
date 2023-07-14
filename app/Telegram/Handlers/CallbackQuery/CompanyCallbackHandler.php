<?php

namespace App\Telegram\Handlers\CallbackQuery;

use App\Services\Cart\CartService;
use App\Telegram\Resolvers\TelegramMessageCartResolver;
use App\Telegram\Senders\CartSenders\CartSender;
use App\Telegram\Senders\CompanySenders\CompanySender;
use Longman\TelegramBot\Entities\CallbackQuery;

class CompanyCallbackHandler
{

    public function __construct(
        private readonly CompanySender $companySender,
        private readonly TelegramMessageCartResolver $telegramMessageCartResolver,
        private readonly CartService $cartService,
        private readonly  CartSender $cartSender,
    )
    {
    }

    public function handle(CallbackQuery $callbackQuery)
    {
        $message = $callbackQuery->getMessage();
        $data = $callbackQuery->getData();
        $data = json_decode($data, true);
        $cityId = $data['id'];
        $chatId = $message->getChat()->getId();

        $cart = $this->telegramMessageCartResolver->resolve($message);
        $cartCityId = $cart->getCityId();

        if($cartCityId != $cityId && $cartCityId != ' ' && $cart->getItems() != []){
            return $this->cartSender->sendRequireChangeCity($chatId);
        }
        $this->cartService->setCityId($cart, $cityId);

        return $this->companySender->send($chatId, $cityId);
    }
}
