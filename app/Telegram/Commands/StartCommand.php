<?php

namespace App\Telegram\Commands;

use App\Telegram\Handlers\Commands\StartCommandHandler;
use App\Telegram\Handlers\Language\LanguageLocalizeHandler;
use Longman\TelegramBot\Entities\ServerResponse;

class StartCommand extends BaseCommand
{
    protected $name = 'start';
    protected $usage = '/start';

    public function execute(): ServerResponse
    {
        app(LanguageLocalizeHandler::class)->handle($this->getMessage());
        return app(StartCommandHandler::class)->handle($this);
    }
}
