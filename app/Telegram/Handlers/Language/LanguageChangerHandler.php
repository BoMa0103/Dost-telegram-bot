<?php

namespace App\Telegram\Handlers\Language;

use App\Services\Users\UsersService;
use App\Telegram\Senders\LanguageSenders\LanguageSender;
use App\Telegram\Senders\MenuSenders\TelegramMenuSender;
use Longman\TelegramBot\Entities\CallbackQuery;

class LanguageChangerHandler
{
    public function __construct(
        private readonly UsersService $usersService,
        private readonly LanguageSender $languageSender,
        private readonly TelegramMenuSender $telegramMenuSender,
    )
    {
    }

    public function handle(CallbackQuery $callbackQuery)
    {
        $chatId = $callbackQuery->getMessage()->getChat()->getId();
        $data = $callbackQuery->getData();
        $data = json_decode($data, true);
        $answer = $data['language'];

        $user = $this->usersService->findUserByTelegramId($chatId);

        if($user){
            $this->usersService->updateUser($user, [
                'lang' => $answer,
            ]);
        }

        app(LanguageLocalizeHandler::class)->handle($callbackQuery->getMessage());

        $this->languageSender->sendLanguageSuccussfullyChanged($chatId);
        return $this->telegramMenuSender->send($chatId);
    }
//    private function generateUserDTO(string $answer): UserDTO
//    {
//        return UserDTO::fromArray([
//            'lang' => $answer,
//        ]);
//    }
}
