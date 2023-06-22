<?php

namespace App\Services\Orders;

use App\Models\Order;
use App\Services\Cart\DTO\CartDTO;
use App\Services\Orders\Handlers\CreateOrderHandler;
use App\Services\Orders\Repositories\OrderRepositoryInterface;
use Longman\TelegramBot\Entities\Message;

class OrdersService
{

    public function __construct(
        private readonly CreateOrderHandler $createOrderHandler,
        private readonly OrderRepositoryInterface $orderRepository
    )
    {
    }

    /**
     * @param CartDTO $cartDTO
     * @return Order
     */
    public function createOrder(Message $message, CartDTO $cartDTO): ?Order
    {
        return $this->createOrderHandler->handle($message, $cartDTO);
    }

}
