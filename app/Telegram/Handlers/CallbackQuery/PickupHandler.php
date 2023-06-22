<?php

namespace App\Telegram\Handlers\CallbackQuery;

use App\Services\Cart\CartService;
use App\Services\Dots\DotsService;
use App\Services\Dots\DTO\OrderDTO;
use App\Telegram\Resolvers\TelegramMessageCartResolver;
use App\Telegram\Senders\CompanyAddressesSender;
use Illuminate\Support\Facades\Log;
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

        $this->cartService->setDeliveryType($cart, OrderDTO::DELIVERY_PICKUP);

        $companyId = $cart->getCompanyId();

        $chatId = $message->getChat()->getId();

        return $this->companyAddressesSender->send($chatId, $companyId);
    }
}
