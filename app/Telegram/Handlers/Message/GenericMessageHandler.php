<?php

namespace App\Telegram\Handlers\Message;


use App\Telegram\Commands\Command;
use App\Telegram\Handlers\CallbackQuery\CompanyCallbackHandler;
use App\Telegram\Handlers\CreateTelegramOrderHandler;
use App\Telegram\Handlers\Language\LanguageHandler;
use App\Telegram\Handlers\Language\LanguageLocalizeHandler;
use App\Telegram\Resolvers\MessageCommandResolver;
use App\Telegram\Senders\NotFoundMessageSender;
use Longman\TelegramBot\Entities\Message;

class GenericMessageHandler
{
    /** @var NotFoundMessageSender */
    private $notFoundMessageSender;
    /** @var MessageCommandResolver */
    private $messageCommandResolver;

    public function __construct(
        NotFoundMessageSender  $notFoundMessageSender,
        MessageCommandResolver $messageCommandResolver,
    )
    {
        $this->notFoundMessageSender = $notFoundMessageSender;
        $this->messageCommandResolver = $messageCommandResolver;
    }

    public function handle(Message $message)
    {
        app(LanguageLocalizeHandler::class)->handle($message);

        $command = $this->messageCommandResolver->resolve($message);
        switch ($command) {
            case Command::ORDER:
                return app(CreateTelegramOrderHandler::class)->handle($message);
            case Command::CITY:
                return app(CityMessageHandler::class)->handle($message);
            case Command::COMPANY:
                return app(CompanyCallbackHandler::class)->handleMessage($message);
            case Command::CART:
                return app(CartMessageHandler::class)->handle($message);
            case Command::DISHES:
                return app(DishCategoryMessageHandler::class)->handle($message);
            case Command::LANGUAGE:
                return app(LanguageHandler::class)->handle($message);
            default:
                return $this->notFoundMessageSender->send($message->getChat()->getId());
        }
    }

}
