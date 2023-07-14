<?php

namespace App\Telegram\Commands;

use App\Telegram\Handlers\Language\LanguageLocalizeHandler;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;

class GenericCommand extends BaseCommand
{
    protected $name = 'generic';

    public function execute(): ServerResponse
    {
        app(LanguageLocalizeHandler::class)->handle($this->getMessage());
        $message = $this->getMessage();
        $chat_id = $message->getChat()->getId();

        $data = [
            'chat_id' => $chat_id,
            'text'    => trans('bots.suchCommandDoesNotExist'),
        ];
        return Request::sendMessage($data);
    }
}
