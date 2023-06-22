<?php

namespace App\Telegram\Handlers\CallbackQuery;

use App\Services\Cart\CartService;
use App\Telegram\Resolvers\TelegramMessageCartResolver;
use App\Telegram\Senders\CartSender;
use App\Telegram\Senders\DishCategorySender;
use Longman\TelegramBot\Entities\CallbackQuery;

class DishCategoryCallbackHandler
{

    public function __construct(
        private readonly DishCategorySender $dishCategorySender,
        private readonly CartSender $cartSender,
        private readonly TelegramMessageCartResolver $telegramMessageCartResolver,
        private readonly CartService $cartService,
    )
    {
    }

    public function handle(CallbackQuery $callbackQuery)
    {
        $message = $callbackQuery->getMessage();
        $chatId = $message->getChat()->getId();
        $data = $callbackQuery->getData();
        $data = json_decode($data, true);
        $companyId = $data['id'];

        $cart = $this->telegramMessageCartResolver->resolve($message);
        $cartCompanyId = $cart->getCompanyId();

        if($cartCompanyId != $companyId && $cartCompanyId != ' ' && $cart->getItems() != []){
            return $this->cartSender->sendRequireChangeCompany($chatId, $companyId);
        }
        $this->cartService->setCompanyId($cart, $companyId);

        return $this->dishCategorySender->send($chatId, $companyId);
    }

}
