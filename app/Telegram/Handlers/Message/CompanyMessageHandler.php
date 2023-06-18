<?php

namespace App\Telegram\Handlers\Message;

use App\Services\Cart\CartService;
use App\Telegram\Resolvers\TelegramMessageCartResolver;
use App\Telegram\Senders\CompanySender;
use Longman\TelegramBot\Entities\Message;

class CompanyMessageHandler
{
    /** @var CompanySender */
    private $companySender;
    /** @var TelegramMessageCartResolver */
    private $telegramMessageCartResolver;

    public function __construct(
        CompanySender $companySender,
        TelegramMessageCartResolver $telegramMessageCartResolver,
    )
    {
        $this->companySender = $companySender;
        $this->telegramMessageCartResolver = $telegramMessageCartResolver;
    }

    public function handle(Message $message)
    {
        $cart = $this->telegramMessageCartResolver->resolve($message);

        $cityId = $cart->getCityId();
        $chatId = $message->getChat()->getId();

        return $this->companySender->send($chatId, $cityId);
    }

}
