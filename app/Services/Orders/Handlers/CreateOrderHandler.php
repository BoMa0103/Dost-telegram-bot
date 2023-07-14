<?php

namespace App\Services\Orders\Handlers;

use App\Models\Order;
use App\Services\Cart\DTO\CartDTO;
use App\Services\Dots\DotsService;
use App\Services\Dots\DTO\DotsDTO;
use App\Services\Dots\DTO\DotsOrderDTO;
use App\Services\Orders\DTO\OrderDTO;
use App\Services\Orders\Repositories\OrderRepository;
use App\Telegram\Senders\CommonSenders\MessageSender;
use Illuminate\Support\Facades\Log;

class CreateOrderHandler
{
    private const NO_WORKING_TIME_MESSAGE = 'The company does not work at the time selected in the order';
    private const STOP_ACCEPT_ORDERS_MESSAGE = 'Unfortunately, this company suspended the acceptance of orders.';

    public function __construct(
        private readonly DotsService     $dotsService,
        private readonly OrderRepository $orderRepository,
        private readonly MessageSender   $messageSender,
    ) {
    }

    /**
     * @param int $chatId
     * @param CartDTO $cartDTO
     * @return Order|null
     */
    public function handle(int $chatId, CartDTO $cartDTO): ?Order
    {
        $orderData = $this->dotsService->makeOrder($this->generateDotsOrderData($cartDTO));

        if(!$this->resultOrderDataCheck($chatId, $orderData)){
            return null;
        }

        return $this->orderRepository->createFromArray(
            $this->generateOrderData($cartDTO, $orderData)->toArray()
        );
    }

    private function resultOrderDataCheck(int $chatId, array $orderData)
    {
        if(array_key_exists('id', $orderData)){
            return true;
        }
        if($orderData['message'] == self::NO_WORKING_TIME_MESSAGE){
            $this->messageSender->send($chatId, trans('bots.noWorkingTime'));
            return false;
        }
        if($orderData['message'] == self::STOP_ACCEPT_ORDERS_MESSAGE){
            $this->messageSender->send($chatId, trans('bots.stopAcceptOrders'));
            return false;
        }
        Log::info('Unknown order data: ', $orderData);
    }

    /**
     * @param CartDTO $cartDTO
     * @return array
     */
    private function generateDotsOrderData(CartDTO $cartDTO): DotsOrderDTO
    {
        return $this->createOrderDTO($cartDTO);
    }

    private function createOrderDTO(CartDTO $cartDTO): DotsOrderDTO
    {
        return DotsOrderDTO::fromArray([
            'cityId' => $cartDTO->getCityId(),
            'companyId' => $cartDTO->getCompanyId(),
            'deliveryAddressStreet' => $cartDTO->getDeliveryAddressStreet(),
            'deliveryAddressHouse'=> $cartDTO->getDeliveryAddressHouse(),
            'companyAddressId' => $cartDTO->getCompanyAddressId(),
            'userName' => $cartDTO->getUser()->getName(),
            'userPhone' => $cartDTO->getUser()->getPhone(),
            'deliveryType' => $cartDTO->getDeliveryType(),
            'deliveryTime' => DotsDTO::DELIVERY_TIME_FASTEST,
            'paymentType' => DotsDTO::PAYMENT_ONLINE,
            'cartItems' => $this->generateDotsOrderCartData($cartDTO),
        ]);
    }

    /**
     * @param CartDTO $cartDTO
     * @return array
     */
    private function generateDotsOrderCartData(CartDTO $cartDTO): array
    {
        $result = [];
        foreach ($cartDTO->getItems() as $item) {
            $result[] = [
                'id' => $item->getDishId(),
                'count' => $item->getCount(),
                'price' => $item->getPrice(),
            ];
        }
        return $result;
    }

    /**
     * @param CartDTO $cartDTO
     * @param array $dotsOrderData
     * @return OrderDTO
     */
    private function generateOrderData(CartDTO $cartDTO, array $dotsOrderData): OrderDTO
    {
        $orderId = $dotsOrderData['id'];

        $paymentData = $this->dotsService->getOnlinePaymentData($orderId);

        $paymentUrl = '';

        if ($paymentData && $paymentData['onlinePayment'] && $paymentData['checkoutUrl']) {
            $data['paymentUrl'] = $paymentData['checkoutUrl'];
        }

        $data = $this->generateOrderDataFromCart($cartDTO, $orderId, $paymentUrl);

        Log::info("Order data: ", $data->toArray());

        return $data;
    }

    /**
     * @param CartDTO $cartDTO
     * @return OrderDTO
     */
    private function generateOrderDataFromCart(CartDTO $cartDTO, string $orderId, string $paymentUrl): OrderDTO
    {
        return OrderDTO::fromArray([
            'order_id' => $orderId,
            'userName' => $cartDTO->getUser()->getName(),
            'userPhone' => $cartDTO->getUser()->getPhone(),
            'user_id' => $cartDTO->getUser()->getId(),
            'items' => $cartDTO->getItemsArray(),
            'company_id' => $cartDTO->getCompanyId(),
            'paymentUrl' => $paymentUrl,
        ]);
    }

}
