<?php

namespace App\Services\Dots\DTO;

class DotsOrderDTO
{
    private function __construct(
        private string $cityId,
        private string $companyId,
        private string $companyAddressId,
        private string $userName,
        private string $userPhone,
        private int $deliveryType,
        private int $paymentType,
        private int $deliveryTime,
        private array $cartItems,
    )
    {
    }

    public static function fromArray(array $data): DotsOrderDTO
    {
        return new self(
            $data['cityId'],
            $data['companyId'],
            $data['companyAddressId'],
            $data['userName'],
            $data['userPhone'],
            $data['deliveryType'],
            $data['paymentType'],
            $data['deliveryTime'],
            $data['cartItems'],
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'cityId' => $this->getCityId(),
            'companyId' => $this->getCompanyId(),
            'companyAddressId' => $this->getCompanyAddressId(),
            'userName' => $this->getUserName(),
            'userPhone' => $this->getUserPhone(),
            'deliveryType' => $this->getDeliveryType(),
            'paymentType' => $this->getPaymentType(),
            'deliveryTime' => $this->getDeliveryTime(),
            'cartItems' => $this->getCartItems(),
        ];
    }

    /**
     * @return string
     */
    public function getCityId(): string
    {
        return $this->cityId;
    }

    /**
     * @param string $cityId
     */
    public function setCityId(string $cityId): void
    {
        $this->cityId = $cityId;
    }

    /**
     * @return string
     */
    public function getCompanyId(): string
    {
        return $this->companyId;
    }

    /**
     * @param string $companyId
     */
    public function setCompanyId(string $companyId): void
    {
        $this->companyId = $companyId;
    }

    /**
     * @return string
     */
    public function getCompanyAddressId(): string
    {
        return $this->companyAddressId;
    }

    /**
     * @param string $companyAddressId
     */
    public function setCompanyAddressId(string $companyAddressId): void
    {
        $this->companyAddressId = $companyAddressId;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     */
    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }

    /**
     * @return string
     */
    public function getUserPhone(): string
    {
        return $this->userPhone;
    }

    /**
     * @param string $userPhone
     */
    public function setUserPhone(string $userPhone): void
    {
        $this->userPhone = $userPhone;
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
     * @return int
     */
    public function getPaymentType(): int
    {
        return $this->paymentType;
    }

    /**
     * @param int $paymentType
     */
    public function setPaymentType(int $paymentType): void
    {
        $this->paymentType = $paymentType;
    }

    /**
     * @return int
     */
    public function getDeliveryTime(): int
    {
        return $this->deliveryTime;
    }

    /**
     * @param int $deliveryTime
     */
    public function setDeliveryTime(int $deliveryTime): void
    {
        $this->deliveryTime = $deliveryTime;
    }

    /**
     * @return array
     */
    public function getCartItems(): array
    {
        return $this->cartItems;
    }

    /**
     * @param array $cartItems
     */
    public function setCartItems(array $cartItems): void
    {
        $this->cartItems = $cartItems;
    }

}
