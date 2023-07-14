<?php

namespace App\Services\Orders;

use App\Models\Order;
use App\Services\Cart\DTO\CartDTO;
use App\Services\Orders\Handlers\CreateOrderHandler;
use Longman\TelegramBot\Entities\Message;

class OrdersService
{
    public function __construct(
        private readonly CreateOrderHandler $createOrderHandler,
    )
    {
    }

    /**
     * @param int $chatId
     * @param CartDTO $cartDTO
     * @return Order|null
     */
    public function createOrder(int $chatId, CartDTO $cartDTO): ?Order
    {
        return $this->createOrderHandler->handle($chatId, $cartDTO);
    }

}
