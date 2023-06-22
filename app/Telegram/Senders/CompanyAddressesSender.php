<?php

namespace App\Telegram\Senders;

use App\Services\Dots\DotsService;
use Longman\TelegramBot\Entities\InlineKeyboard;

class CompanyAddressesSender extends TelegramSender
{

    public function __construct(
        private readonly DotsService $dotsService
    )
    {
    }

    public function send(int $chatId, string $companyId)
    {
        $inlineKeyboard = $this->getAddessesKeyboard($companyId);
        if(!$inlineKeyboard){
            $data = [
                'chat_id' => $chatId,
                'text' => trans('bots.pickupPointsNotFound'),
            ];
            return $this->sendData($data);
        }
        $data = [
            'chat_id' => $chatId,
            'text' => trans('bots.choosePickupPoint'),
            'reply_markup' => $inlineKeyboard
        ];
        return $this->sendData($data);
    }

    /**
     * @param string $companyId
     * @return InlineKeyboard|null
     */
    private function getAddessesKeyboard(string $companyId): ?InlineKeyboard
    {
        $items = $this->getAddressItems($companyId);
        if(!$items){
            return null;
        }
        $keyboard = new InlineKeyboard(...$items);
        return $keyboard
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true)
            ->setSelective(false);
    }

    /**
     * @return array
     */
    private function getAddressItems(string $companyId): ?array
    {
        $companyInfo = $this->dotsService->getCompanyInfo($companyId);

        if(!array_key_exists('addresses', $companyInfo)){
            return null;
        }else{
            $companyAddresses = $companyInfo['addresses'];
        }

        $items = [];
        foreach ($companyAddresses as $companyAddress) {
            $items[] = [[
                'text' => $companyAddress['title'],
                'callback_data' => '{"type":"address","id":"' . $companyAddress['id'] . '"}',
            ]];
        }
        return $items;
    }
}
