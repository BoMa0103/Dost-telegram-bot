<?php

namespace App\Telegram\Handlers\Message;


use App\Telegram\Commands\Command;
use App\Telegram\Handlers\CreateTelegramOrderHandler;
use App\Telegram\Handlers\DeliveryTypesHandler;
use App\Telegram\Handlers\Language\LanguageHandler;
use App\Telegram\Handlers\Language\LanguageLocalizeHandler;
use App\Telegram\Resolvers\MessageCommandResolver;
use App\Telegram\Senders\CommonSenders\NotFoundMessageSender;
use Longman\TelegramBot\Entities\Message;

class GenericMessageHandler
{
    public function __construct(
        private readonly NotFoundMessageSender  $notFoundMessageSender,
        private readonly MessageCommandResolver $messageCommandResolver,
    )
    {
    }

    public function handle(Message $message)
    {
        app(LanguageLocalizeHandler::class)->handle($message);

        $command = $this->messageCommandResolver->resolve($message);

        switch ($command) {
            case Command::ORDER:
                return app(DeliveryTypesHandler::class)->handle($message);
            case Command::CITY:
                return app(CityMessageHandler::class)->handle($message);
            case Command::COMPANY:
                return app(CompanyMessageHandler::class)->handle($message);
            case Command::CART:
                return app(CartMessageHandler::class)->handle($message);
            case Command::DISHES:
                return app(DishCategoryMessageHandler::class)->handle($message);
            case Command::LANGUAGE:
                return app(LanguageHandler::class)->handle($message);
            case Command::STREET_ADDRESS:
                return app(StreetAddressHandler::class)->handle($message);
            case Command::HOUSE_ADDRESS:
                return app(CreateTelegramOrderHandler::class)->handleMessage($message);
            default:
                return $this->notFoundMessageSender->send($message->getChat()->getId());
        }
    }

}
