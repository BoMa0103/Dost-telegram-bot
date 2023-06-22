<?php

namespace App\Telegram\Handlers\Message;

use App\Services\Cart\CartService;
use App\Telegram\Resolvers\TelegramMessageCartResolver;
use App\Telegram\Senders\CompanySender;
use Longman\TelegramBot\Entities\Message;

class CompanyMessageHandler
{
    public function __construct(
        private readonly  CompanySender $companySender,
        private readonly TelegramMessageCartResolver $telegramMessageCartResolver,
    )
    {
    }

    public function handle(Message $message)
    {
        $cart = $this->telegramMessageCartResolver->resolve($message);

        $cityId = $cart->getCityId();
        $chatId = $message->getChat()->getId();

        return $this->companySender->send($chatId, $cityId);
    }

}
