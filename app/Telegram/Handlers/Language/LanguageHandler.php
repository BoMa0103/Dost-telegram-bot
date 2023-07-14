<?php

namespace App\Telegram\Handlers\Language;

use App\Services\Users\UsersService;
use App\Telegram\Senders\LanguageSenders\LanguageSender;
use Longman\TelegramBot\Entities\Message;

class LanguageHandler
{
    public function __construct(
        private readonly LanguageSender $languageSender,
    )
    {
    }

    public function handle(Message $message)
    {
        $chatId = $message->getChat()->getId();

        return $this->languageSender->send($chatId);
    }
}
