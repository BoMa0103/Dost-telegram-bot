<?php

namespace App\Services\Cart\Handlers;

use App\Models\Order;
use App\Services\Cart\DTO\CartDTO;
use App\Services\Cart\Repositories\CartRepository;
use App\Services\Orders\OrdersService;
use Longman\TelegramBot\Entities\Message;

class CreateOrderHandler
{
    public function __construct(
        private readonly OrdersService $ordersService,
        private readonly CartRepository $cartRepository
    )
    {
    }

    /**
     * @param int $chatId
     * @param CartDTO $cartDTO
     * @return Order|null
     */
    public function handle(int $chatId, CartDTO $cartDTO): ?Order
    {
        $order = $this->ordersService->createOrder($chatId, $cartDTO);
        $this->cartRepository->clearItems($cartDTO);
        return $order;
    }

}
