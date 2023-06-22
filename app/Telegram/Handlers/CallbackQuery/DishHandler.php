<?php

namespace App\Telegram\Handlers\CallbackQuery;

use App\Telegram\Senders\DishSender;
use Longman\TelegramBot\Entities\CallbackQuery;

class DishHandler
{
    public function __construct(
        private readonly DishSender $dishSender,
    )
    {
    }

    public function handle(CallbackQuery $callbackQuery)
    {
        return $this->dishSender->reply($callbackQuery);
    }
}
