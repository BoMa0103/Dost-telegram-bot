<?php

namespace App\Services\Cart\DTO;

class CartDTO
{

    private $key;
    private $items = [];
    private $user;
    private $companyId;
    private $cityId;
    private $companyAddressId;
    private $deliveryType;
    private $deliveryAddressStreet;
    private $deliveryAddressHouse;

    private function __construct(
        string $key,
        array $items,
        CartUserDTO $user,
        string $companyId,
        string $cityId,
        string $companyAddressId,
        int $deliveryType,
        string $deliveryAddressStreet,
        string $deliveryAddressHouse,
    ) {
        $this->key = $key;
        $this->items = $items;
        $this->user = $user;
        $this->companyId = $companyId;
        $this->cityId = $cityId;
        $this->companyAddressId = $companyAddressId;
        $this->deliveryType = $deliveryType;
        $this->deliveryAddressStreet = $deliveryAddressStreet;
        $this->deliveryAddressHouse = $deliveryAddressHouse;
    }

    public static function fromArray(array $data): CartDTO
    {
        $items = $data['items'] ?? [];
        return new self(
            $data['key'],
            array_map(function (array $item) {
                return CartItemDTO::fromArray($item);
            }, $items),
            CartUserDTO::fromArray($data['user'] ?? []),
            $data['company_id'] ?? ' ',
            $data['city_id'] ?? ' ',
            $data['company_address_id'] ?? ' ',
            $data['delivery_type'] ?? -1,
            $data['delivery_address_street'] ?? ' ',
            $data['delivery_address_house'] ?? ' ',
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'key' => $this->getKey(),
            'items' => $this->getItemsArray(),
            'user' => $this->getUser()->toArray(),
            'company_id' => $this->getCompanyId(),
            'city_id' => $this->getCityId(),
            'company_address_id' => $this->getCompanyAddressId(),
            'delivery_type' => $this->getDeliveryType(),
            'delivery_address_street' => $this->getDeliveryAddressStreet(),
            'delivery_address_house' => $this->getDeliveryAddressHouse(),
        ];
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return array
     */
    public function getItemsArray(): array
    {
        return array_map(function (CartItemDTO $cartItemDTO) {
            return $cartItemDTO->toArray();
        }, $this->getItems());
    }

    /**
     * @return int
     */
    public function getDeliveryType(): int
    {
        return $this->deliveryType;
    }

    /**
     * @param int $deliveryType
     */
    public function setDeliveryType(int $deliveryType): void
    {
        $this->deliveryType = $deliveryType;
    }

    /**
     * @return CartItemDTO[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function clearItems(): void
    {
        $this->items = [];
    }

    public function clearCompany(): void
    {
        $this->companyId = ' ';
    }

    public function clearCompanyAddress(): void
    {
        $this->companyAddressId = ' ';
    }

    public function clearCity(): void
    {
        $this->cityId = ' ';
    }

    public function clearDeliveryType(): void
    {
        $this->deliveryType = -1;
    }

    public function clearDeliveryAddressStreet(): void
    {
        $this->deliveryAddressStreet = ' ';
    }

    public function clearDeliveryAddressHouse(): void
    {
        $this->deliveryAddressHouse = ' ';
    }

    /**
     * @return CartUserDTO
     */
    public function getUser(): CartUserDTO
    {
        return $this->user;
    }

    /**
     * @param array $data
     */
    public function addItem(array $data)
    {
        $this->items[] = CartItemDTO::fromArray($data);
    }

    /**
     * @param array $data
     */
    public function setItems(array $items)
    {
        $this->items = $items;
    }

    /**
     * @param string $companyId
     * @return void
     */
    public function setCompanyId(string $companyId): void
    {
        $this->companyId = $companyId;
    }


    /**
     * @return string
     */
    public function getCompanyId(): string
    {
        return $this->companyId;
    }

    /**
     * @return string
     */
    public function getDeliveryAddressStreet(): string
    {
        return $this->deliveryAddressStreet;
    }

    /**
     * @param string $deliveryAddressStreet
     */
    public function setDeliveryAddressStreet(string $deliveryAddressStreet): void
    {
        $this->deliveryAddressStreet = $deliveryAddressStreet;
    }

    /**
     * @return string
     */
    public function getDeliveryAddressHouse(): string
    {
        return $this->deliveryAddressHouse;
    }

    /**
     * @param string $deliveryAddressHouse
     */
    public function setDeliveryAddressHouse(string $deliveryAddressHouse): void
    {
        $this->deliveryAddressHouse = $deliveryAddressHouse;
    }

    /**
     * @param string $companyId
     * @return void
     */
    public function setCompanyAddressId(string $companyAddressId): void
    {
        $this->companyAddressId = $companyAddressId;
    }


    /**
     * @return string
     */
    public function getCompanyAddressId(): string
    {
        return $this->companyAddressId;
    }

    /**
     * @param string $cityId
     * @return void
     */
    public function setCityId(string $cityId): void
    {
        $this->cityId = $cityId;
    }

    /**
     * @return string
     */
    public function getCityId(): string
    {
        return $this->cityId;
    }

}
