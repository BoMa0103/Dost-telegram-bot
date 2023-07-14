<?php

namespace App\Telegram\Senders\CartSenders;

use App\Services\Cart\DTO\CartDTO;
use App\Services\Cart\DTO\CartItemDTO;
use App\Telegram\Senders\CommonSenders\TelegramSender;
use Longman\TelegramBot\Entities\InlineKeyboard;

class CartSender extends TelegramSender
{
    public function sendCart(int $chatId, CartDTO $cart)
    {
        if($this->getCartInfo($cart)){
            $data = [
                'chat_id' => $chatId,
                'text'    => $this->getCartInfo($cart),
                'reply_markup' => $this->getClearCartKeyboard(),
            ];
        } else {
            $data = [
                'chat_id' => $chatId,
                'text'    => trans('bots.cartEmpty'),
            ];
        }
        return $this->sendData($data);
    }

    private function getCartInfo(CartDTO $cart): string
    {
        return $this->generateCarItemsMessage($cart);
    }

    /**
     * @param CartDTO $cart
     * @return string
     */
    private function generateCarItemsMessage(CartDTO $cart): string
    {
        $result = [];
        foreach ($cart->getItems() as $item) {
            $result[] = $this->generateCartItemMessage($item);
        }
        return implode(PHP_EOL, $result);
    }

    /**
     * @param CartItemDTO $item
     * @return string
     */
    private function generateCartItemMessage(CartItemDTO $item): string
    {
        return sprintf(
            '%s - %s',
            $item->getName(),
            $item->getCount()
        );
    }

    public function sendRequireChangeCompany(int $chatId, string $companyId)
    {
        $inlineKeyboard = $this->getChangeCompanyApproveKeyboard($companyId);

        $data = [
            'chat_id' => $chatId,
            'text'    => trans('bots.requireChangeCompany'),
            'reply_markup' => $inlineKeyboard,
        ];
        return $this->sendData($data);
    }

    public function sendRequireChangeCity(int $chatId)
    {
        $inlineKeyboard = $this->getChangeCityApproveKeyboard();

        $data = [
            'chat_id' => $chatId,
            'text'    => trans('bots.requireChangeCity'),
            'reply_markup' => $inlineKeyboard,
        ];
        return $this->sendData($data);
    }

    public function sendCartClearSuccessful(int $chatId)
    {
        $data = [
            'chat_id' => $chatId,
            'text'    => trans('bots.cartClearSuccessful'),
        ];
        return $this->sendData($data);
    }

    public function sendChangeCompanySuccessful(int $chatId)
    {
        $data = [
            'chat_id' => $chatId,
            'text'    => trans('bots.changeCompanySuccessful'),
        ];
        return $this->sendData($data);
    }

    public function sendChangeCitySuccessful(int $chatId)
    {
        $data = [
            'chat_id' => $chatId,
            'text'    => trans('bots.changeCitySuccessful'),
        ];
        return $this->sendData($data);
    }

    private function getClearCartKeyboard(): InlineKeyboard
    {
        $items = [];
        $items[] = [[
            'text' => trans('bots.clearCart'),
            'callback_data' => '{"type": "clearCart", "value": "yes"}',
        ]];
        $keyboard = new InlineKeyboard(...$items);
        return $keyboard
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true)
            ->setSelective(false);
    }

    private function getChangeCompanyApproveKeyboard(string $companyId): InlineKeyboard
    {
        $items = [];
        $items[] = [[
                'text' => trans('bots.yes'),
                'callback_data' => '{"type": "changeCompany", "value": "yes"}',
            ],
            [
                'text' => trans('bots.no'),
                'callback_data' => '{"type": "changeCompany", "value": "no"}',
            ]];
        $keyboard = new InlineKeyboard(...$items);
        return $keyboard
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true)
            ->setSelective(false);
    }

    private function getChangeCityApproveKeyboard(): InlineKeyboard
    {
        $items = [];
        $items[] = [[
            'text' => 'Yes',
            'callback_data' => '{"type": "changeCity", "value": "yes"}',
        ],
            [
                'text' => 'No',
                'callback_data' => '{"type": "changeCity", "value": "no"}',
            ]];
        $keyboard = new InlineKeyboard(...$items);
        return $keyboard
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true)
            ->setSelective(false);
    }
}
