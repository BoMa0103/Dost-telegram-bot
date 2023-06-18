<?php

namespace App\Telegram\Handlers\CallbackQuery;

use App\Telegram\Senders\DishSender;
use Longman\TelegramBot\Entities\CallbackQuery;

class DishHandler
{
    /** @var DishSender */
    private $dishSender;

    public function __construct(
        DishSender $dishSender,
    )
    {
        $this->dishSender = $dishSender;
    }

    public function handle(CallbackQuery $callbackQuery)
    {
        return $this->dishSender->reply($callbackQuery);
    }
}
