<?php

namespace App\Telegram\Handlers\CallbackQuery;

use App\Services\Cart\CartService;
use App\Services\Dots\DTO\DotsDTO;
use App\Telegram\Resolvers\TelegramMessageCartResolver;
use App\Telegram\Senders\CompanySenders\CompanyAddressesSender;
use Longman\TelegramBot\Entities\CallbackQuery;

class PickupHandler
{
    public function __construct(
        private readonly CompanyAddressesSender $companyAddressesSender,
        private readonly TelegramMessageCartResolver $telegramMessageCartResolver,
        private readonly CartService $cartService,
    )
    {
    }

    public function handle(CallbackQuery $callbackQuery)
    {
        $message = $callbackQuery->getMessage();

        $cart = $this->telegramMessageCartResolver->resolve($message);

        $this->cartService->setDeliveryType($cart, DotsDTO::DELIVERY_PICKUP);

        $companyId = $cart->getCompanyId();

        $chatId = $message->getChat()->getId();

        return $this->companyAddressesSender->send($chatId, $companyId);
    }
}
