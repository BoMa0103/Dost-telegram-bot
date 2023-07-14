<?php

namespace App\Telegram\Handlers\CallbackQuery;

use App\Services\Cart\CartService;
use App\Services\Dots\DotsService;
use App\Telegram\Resolvers\TelegramMessageCartResolver;
use App\Telegram\Senders\CartSenders\AddDishToCartSender;
use Longman\TelegramBot\Entities\CallbackQuery;

class AddCartItemHandler
{

    public function __construct(
        private readonly TelegramMessageCartResolver $telegramMessageCartResolver,
        private readonly CartService $cartService,
        private readonly DotsService $dotsService,
        private readonly AddDishToCartSender $addDishToCartSender,
    ){
    }

    public function handle(CallbackQuery $callbackQuery)
    {
        $message = $callbackQuery->getMessage();
        $cart = $this->telegramMessageCartResolver->resolve($message);
        $data = $callbackQuery->getData();
        $data = json_decode($data, true);
        $chatId = $message->getChat()->getId();

        $dish = $this->dotsService->findDishById($data['id']);

        if(!$dish){
            return $this->addDishToCartSender->sendDishNotFound($chatId);
        }

        $dishInfo = $dish['item'];

        $this->cartService->addItem($cart, [
            'dish_id' => $dishInfo['id'],
            'name' => $dishInfo['name'],
            'price' => $dishInfo['price'],
        ]);

        return $this->addDishToCartSender->send($chatId);
    }

}
