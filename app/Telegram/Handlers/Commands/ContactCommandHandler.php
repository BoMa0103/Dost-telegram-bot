<?php

namespace App\Telegram\Handlers\Commands;

use App\Services\Users\UsersService;
use App\Telegram\Senders\CitySender;
use App\Telegram\Senders\ContactSender;
use App\Telegram\Senders\TelegramMenuSender;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;

class ContactCommandHandler extends StartCommandHandler
{
    public function __construct(
        private readonly UsersService $usersService,
        private readonly ContactSender $contactSender,
        private readonly CitySender $citySender,
        private readonly TelegramMenuSender $telegramMenuSender,
    )
    {
    }

    public function handle(SystemCommand $systemCommand): ?ServerResponse
    {
        $message = $systemCommand->getMessage();
        $telegramUserId = $message->getFrom()->getId();
        $user = $this->usersService->findUserByTelegramId($telegramUserId);
        if($user) {
            if($message->getContact()){
                $phoneNumber = $message->getContact()->getPhoneNumber();
                if(str_starts_with($phoneNumber, '+')){
                    $phoneNumber = substr($phoneNumber, 1);
                }
                $this->usersService->updateUser($user, [
                    'phone' => $phoneNumber,
                ]);
            }
        }
        $this->contactSender->send($user->telegram_id);
        $this->telegramMenuSender->send($user->telegram_id);
        return $this->citySender->send($user->telegram_id);
    }
}
