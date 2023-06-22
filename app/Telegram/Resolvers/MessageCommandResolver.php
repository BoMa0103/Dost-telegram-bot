<?php
/**
 * Description of MessageCommandResolver.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Telegram\Resolvers;


use App\Telegram\Commands\Command;
use App\Telegram\Handlers\Language\LanguageLocalizeHandler;
use Illuminate\Support\Facades\Log;
use Longman\TelegramBot\Entities\Message;
use Longman\TelegramBot\Request;

class MessageCommandResolver
{

    /**
     * @param Message $message
     * @return string|null
     */
    public function resolve(Message $message): ?string
    {

        if ($message->getText() === trans('bots.changeCity')) {
            return Command::CITY;
        } elseif ($message->getText() === trans('bots.changeCompany')) {
            return Command::COMPANY;
        } elseif ($message->getText() === trans('bots.selectDishes')) {
            return Command::DISHES;
        } elseif ($message->getText() === trans('bots.showCart')) {
            return Command::CART;
        } elseif ($message->getText() === trans('bots.makeOrder')) {
            return Command::ORDER;
        } elseif ($message->getText() === trans('bots.changeLanguage')) {
            return Command::LANGUAGE;
        } elseif ($this->isStreetAddress($message->getText())) {
            return Command::STREET_ADDRESS;
        } elseif ($this->isHouseAddress($message->getText())) {
            return Command::HOUSE_ADDRESS;
        } elseif ($this->isCommandLocationSharing($message)) {
            return Command::LOCATION;
        }
        return null;
    }

    private function isStreetAddress(string $message) {
        $keywords = array('улица', 'город', 'вулиця', 'будинок', 'місто', 'провулок', 'ул.', 'вул.', 'street', 'st.');
        $lowerMessage = mb_strtolower($message);
        Log::info('Street address: ' . $lowerMessage);
        foreach ($keywords as $keyword) {
            if (stripos($lowerMessage, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }

    private function isHouseAddress(string $message) {
        $keywords = array('дом', 'дім', 'квартира', 'кв.', 'кв', 'будинок', 'буд.', 'буд', 'house');
        $lowerMessage = mb_strtolower($message);
        Log::info('House address: ' . $lowerMessage);
        foreach ($keywords as $keyword) {
            if (stripos($lowerMessage, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Message $message
     * @return bool
     */
    private function isCommandLocationSharing(Message $message): bool
    {
        return $message->getLocation() && $message->getLocation()->getLatitude();
    }

}
