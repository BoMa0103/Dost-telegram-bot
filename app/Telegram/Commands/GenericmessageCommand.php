<?php

namespace App\Telegram\Commands;

use App\Telegram\Handlers\Language\LanguageLocalizeHandler;
use App\Telegram\Handlers\Message\GenericMessageHandler;
use Longman\TelegramBot\Entities\ServerResponse;

class GenericmessageCommand extends BaseCommand
{
    protected $name = 'genericmessage';

    public function execute(): ServerResponse
    {
        app(LanguageLocalizeHandler::class)->handle($this->getMessage());
        return app()->make(GenericMessageHandler::class)->handle($this->getMessage());
    }
}
