<?php

namespace App\Telegram\Handlers;

use App\Models\Order;
use App\Services\Cart\CartService;
use App\Services\Dots\DotsService;
use App\Telegram\Handlers\Senders\SendAdminOrderMessageHandler;
use App\Telegram\Resolvers\TelegramMessageCartResolver;
use App\Telegram\Senders\MessageSender;
use App\Telegram\Senders\SuccessMessageToUser;
use Longman\TelegramBot\Entities\CallbackQuery;
use Longman\TelegramBot\Entities\Message;

class CreateTelegramOrderHandler
{
    public function __construct(
        private readonly TelegramMessageCartResolver $telegramMessageCartResolver,
        private readonly SendAdminOrderMessageHandler $sendAdminOrderMessageHandler,
        private readonly MessageSender $messageSender,
        private readonly CartService $cartService,
        private readonly SuccessMessageToUser $successMessageToUser,
    )
    {
    }

    /**
     * @param CallbackQuery $callbackQuery
     * @return Message
     */
    public function handle(CallbackQuery $callbackQuery)
    {
        $message = $callbackQuery->getMessage();
        $data = json_decode($callbackQuery->getData(), true);

        $cart = $this->telegramMessageCartResolver->resolve($message);
        $cart->setCompanyAddressId($data['id']);

        if ($cart->getItems() == []) {
            return $this->sendCartEmptyMessageToUser($message);
        }

        $order = $this->cartService->createOrder($message, $cart);

        if(!$order){
            return $this->sendOrderNotCreate($message);
        }

        $this->sendAdminOrderMessageHandler->handle($order);

        return $this->sendSuccessMessageToUser($message, $order);
    }

    /**
     * @param Message $message
     * @return Message
     */
    public function handleMessage(Message $message)
    {
        $cart = $this->telegramMessageCartResolver->resolve($message);
        $this->cartService->setDeliveryAddressHouse($cart, $message->getText());

        if ($cart->getItems() == []) {
            return $this->sendCartEmptyMessageToUser($message);
        }

        $order = $this->cartService->createOrder($message, $cart);

        if(!$order){
            return $this->sendOrderNotCreate($message);
        }

        $this->sendAdminOrderMessageHandler->handle($order);

        return $this->sendSuccessMessageToUser($message, $order);
    }


    /**
     * @param Message $message
     */
    private function sendCartEmptyMessageToUser(Message $message)
    {
        $text = trans('bots.cartEmpty');

        return $this->messageSender->send($message->getChat()->getId(), $text);
    }

    /**
     * @param Message $message
     */
    private function sendOrderNotCreate(Message $message)
    {
        $text = trans('bots.orderNotCreate');

        return $this->messageSender->send($message->getChat()->getId(), $text);
    }

    /**
     * @param Message $message
     * @param Order $order
     */
    private function sendSuccessMessageToUser(Message $message, Order $order)
    {
        $text = $this->generateSuccessMessage($order);

        return $this->successMessageToUser->send($message->getChat()->getId(), $text, $order['order_id']);
    }

    /**
     * @param Order $order
     * @return string
     */
    private function generateSuccessMessage(Order $order): string
    {
        $message = trans('bots.yourOrderSuccessfullySend');
        if ($order->paymentUrl) {
            $message .= ' ';
            $message .= sprintf(trans('bots.payItOnline'), $order->paymentUrl);
        }
        return $message;
    }

}
