<?php

namespace App\Telegram\Commands;


use App\Telegram\Handlers\Message\GenericMessageHandler;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;

class GenericmessageCommand extends SystemCommand
{
    protected $name = 'genericmessage';

    public function execute(): ServerResponse
    {
        return app()->make(GenericMessageHandler::class)->handle($this->getMessage());
    }
}
