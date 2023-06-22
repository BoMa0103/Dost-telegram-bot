<?php

namespace App\Telegram\Handlers\CallbackQuery;

use App\Services\Users\UsersService;
use App\Telegram\Handlers\CityChangerHandler;
use App\Telegram\Handlers\CompanyChangerHandler;
use App\Telegram\Handlers\CreateTelegramOrderHandler;
use App\Telegram\Handlers\Language\LanguageChangerHandler;
use App\Telegram\Handlers\Language\LanguageLocalizeHandler;
use Longman\TelegramBot\Commands\SystemCommand;

class CallbackQueryHandler
{
    public function __construct(
        private readonly UsersService $usersService,
    )
    {
    }

    public function handle(SystemCommand $systemCommand)
    {
        $callbackQuery = $systemCommand->getCallbackQuery();

        app(LanguageLocalizeHandler::class)->handle($callbackQuery->getMessage());

        $data = $callbackQuery->getData();
        $data = json_decode($data, true);

        switch ($data['type'])
        {
            case 'city':
                return app(CompanyCallbackHandler::class)->handle($callbackQuery);
            case 'company':
                return app(DishCategoryCallbackHandler::class)->handle($callbackQuery);
            case 'cat':
                return app(DishHandler::class)->handle($callbackQuery);
            case 'dish':
                return app(AddCartItemHandler::class)->handle($callbackQuery);
            case 'changeCompany':
                return app(CompanyChangerHandler::class)->handle($callbackQuery);
            case 'changeCity':
                return app(CityChangerHandler::class)->handle($callbackQuery);
            case 'language':
                return app(LanguageChangerHandler::class)->handle($callbackQuery);
            case 'clearCart':
                return app(ClearCartCallbackHandler::class)->handle($callbackQuery);
            case 'deliveryToDoor':
                return app(DeliveryToDoorHandler::class)->handle($callbackQuery);
            case 'deliveryToFlat':
                return app(DeliveryToFlatHandler::class)->handle($callbackQuery);
            case 'pickup':
                return app(PickupHandler::class)->handle($callbackQuery);
            case 'address':
                return app(CreateTelegramOrderHandler::class)->handle($callbackQuery);
            case 'status':
                return app(CheckOrderStatusHandler::class)->handle($callbackQuery);
            default:
        }
    }

}
