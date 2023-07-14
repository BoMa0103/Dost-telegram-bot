<?php
namespace App\Services\Cart;


use App\Models\Order;
use App\Services\Cart\DTO\CartDTO;
use App\Services\Cart\Handlers\CreateOrderHandler;
use App\Services\Cart\Repositories\CartRepository;
use Longman\TelegramBot\Entities\Message;

class CartService
{

    public function __construct(
        private readonly CreateOrderHandler $createOrderHandler,
        private readonly CartRepository $cartRepository
    )
    {
    }

    public function getOrCreateCart(string $key, array $data = []): CartDTO
    {
        $cart = $this->cartRepository->findByKey($key);
        if (!$cart) {
            $cart = $this->create(CartDTO::fromArray(array_merge([
                'key' => $key,
            ], $data)));
        }
        return $cart;
    }

    /**
     * @param CartDTO $cartDTO
     * @return CartDTO
     */
    public function create(CartDTO $cartDTO): CartDTO
    {
        return $this->storeCart($cartDTO);
    }

    /**
     * @param CartDTO $cartDTO
     * @param array $item
     * @return CartDTO
     */
    public function addItem(CartDTO $cartDTO, array $item): CartDTO
    {
        $cartItems = $cartDTO->getItems();

        foreach ($cartItems as $cartItem){
            if($cartItem->getName() === $item['name']){
                $cartItem->addCount();
                $cartDTO->setItems($cartItems);
                return $this->storeCart($cartDTO);
            }
        }
        $cartDTO->addItem($item);
        return $this->storeCart($cartDTO);
    }

    /**
     * @param CartDTO $cartDTO
     * @return CartDTO
     */
    public function storeCart(CartDTO $cartDTO): CartDTO
    {
        return $this->cartRepository->store($cartDTO);
    }

    /**
     * @param CartDTO $cartDTO
     * @return Order
     */
    public function createOrder(Message $message, CartDTO $cartDTO): ?Order
    {
        return $this->createOrderHandler->handle($message->getChat()->getId(), $cartDTO);
    }

    /**
     * @param CartDTO $cartDTO
     * @param string $companyId
     * @return CartDTO
     */
    public function setCompanyId(CartDTO $cartDTO, string $companyId): CartDTO
    {
        $cartDTO->setCompanyId($companyId);
        return $this->storeCart($cartDTO);
    }

    /**
     * @param CartDTO $cartDTO
     * @param string $companyAddressId
     * @return CartDTO
     */
    public function setCompanyAddressId(CartDTO $cartDTO, string $companyAddressId): CartDTO
    {
        $cartDTO->setCompanyAddressId($companyAddressId);
        return $this->storeCart($cartDTO);
    }

    /**
     * @param CartDTO $cartDTO
     * @param int $deliveryType
     * @return CartDTO
     */
    public function setDeliveryType(CartDTO $cartDTO, int $deliveryType): CartDTO
    {
        $cartDTO->setDeliveryType($deliveryType);
        return $this->storeCart($cartDTO);
    }

    /**
     * @param CartDTO $cartDTO
     * @param string $deliveryAddressStreet
     * @return CartDTO
     */
    public function setDeliveryAddressStreet(CartDTO $cartDTO, string $deliveryAddressStreet): CartDTO
    {
        $cartDTO->setDeliveryAddressStreet($deliveryAddressStreet);
        return $this->storeCart($cartDTO);
    }

    /**
     * @param CartDTO $cartDTO
     * @param string $deliveryAddressHouse
     * @return CartDTO
     */
    public function setDeliveryAddressHouse(CartDTO $cartDTO, string $deliveryAddressHouse): CartDTO
    {
        $cartDTO->setDeliveryAddressHouse($deliveryAddressHouse);
        return $this->storeCart($cartDTO);
    }

    /**
     * @param CartDTO $cartDTO
     * @param string $cityId
     * @return CartDTO
     */
    public function setCityId(CartDTO $cartDTO, string $cityId): CartDTO
    {
        $cartDTO->setCityId($cityId);
        return $this->storeCart($cartDTO);
    }

}
