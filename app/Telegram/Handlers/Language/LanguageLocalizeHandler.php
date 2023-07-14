<?php

namespace App\Telegram\Handlers\Language;

use App\Services\Users\UsersService;
use Longman\TelegramBot\Entities\Message;

class LanguageLocalizeHandler
{
    public function __construct(
        private readonly UsersService $usersService,
    )
    {
    }

    /**
     * @param Message $message
     * @return void
     */
    public function handle(Message $message)
    {
        $user = $this->usersService->findUserByTelegramId($message->getChat()->getId());

        if($user){
            app()->setLocale($user->lang);
        } else {
            app()->setLocale($message->getFrom()->getLanguageCode());
        }
    }
}
