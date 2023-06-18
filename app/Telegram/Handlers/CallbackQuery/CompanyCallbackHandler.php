<?php

namespace App\Telegram\Handlers\CallbackQuery;

use App\Services\Cart\CartService;
use App\Telegram\Resolvers\TelegramMessageCartResolver;
use App\Telegram\Senders\CartSender;
use App\Telegram\Senders\CompanySender;
use Longman\TelegramBot\Entities\CallbackQuery;
use Longman\TelegramBot\Entities\Message;

class CompanyCallbackHandler
{
    /** @var CompanySender */
    private $companySender;
    /** @var TelegramMessageCartResolver */
    private $telegramMessageCartResolver;
    /** @var CartService */
    private $cartService;
    /** @var CartSender */
    private $cartSender;

    public function __construct(
        CompanySender $companySender,
        TelegramMessageCartResolver $telegramMessageCartResolver,
        CartService $cartService,
        CartSender $cartSender,
    )
    {
        $this->companySender = $companySender;
        $this->telegramMessageCartResolver = $telegramMessageCartResolver;
        $this->cartService = $cartService;
        $this->cartSender = $cartSender;
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

    public function handleMessage(Message $message)
    {
        $cart = $this->telegramMessageCartResolver->resolve($message);

        $cityId = $cart->getCityId();
        $chatId = $message->getChat()->getId();

        return $this->companySender->send($chatId, $cityId);
    }
}
