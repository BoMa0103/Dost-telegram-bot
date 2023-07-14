<?php

namespace App\Telegram\Handlers\Commands;

use App\Telegram\Handlers\CreateTelegramUserHandler;
use App\Telegram\Senders\CitySenders\CitySender;
use App\Telegram\Senders\MenuSender;
use App\Telegram\Senders\MenuSenders\TelegramMenuSender;
use App\Telegram\Senders\PhoneSenders\RequestPhoneSender;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;

class StartCommandHandler
{
    public function __construct(
        private readonly CreateTelegramUserHandler $createTelegramUserHandler,
        private readonly CitySender $citySender,
        private readonly TelegramMenuSender $telegramMenuSender,
        private readonly RequestPhoneSender $requestPhoneSender
    )
    {
    }

    public function handle(SystemCommand $systemCommand): ServerResponse
    {
        $user = $this->createTelegramUserHandler->handle($systemCommand->getMessage());
        if (!$user->phone) {
            return $this->requestPhoneSender->send($user->telegram_id);
        }
        $this->telegramMenuSender->send($user->telegram_id);
        return $this->citySender->send($user->telegram_id);
    }
}
