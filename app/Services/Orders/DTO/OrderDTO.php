<?php

namespace App\Services\Orders\DTO;

class OrderDTO
{
    private function __construct(
        private int $userId,
        private array $items,
        private string $companyId,
        private string $orderId,
        private ?string $location,
        private ?string $address,
        private string $userName,
        private string $userPhone,
        private ?string $paymentUrl,
    )
    {
    }

    public static function fromArray(array $data): OrderDTO
    {
        return new self(
            $data['user_id'],
            $data['items'],
            $data['company_id'],
            $data['order_id'],
            $data['location'] ?? null,
            $data['address'] ?? null,
            $data['userName'],
            $data['userPhone'],
            $data['paymentUrl'] ?? null,
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'user_id' => $this->getUserId(),
            'items' => $this->getItems(),
            'company_id' => $this->getCompanyId(),
            'order_id' => $this->getOrderId(),
            'location' => $this->getLocation(),
            'address' => $this->getAddress(),
            'userName' => $this->getUserName(),
            'userPhone' => $this->getUserPhone(),
            'paymentUrl' => $this->getPaymentUrl(),
        ];
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
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
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * @param string $orderId
     */
    public function setOrderId(string $orderId): void
    {
        $this->orderId = $orderId;
    }

    /**
     * @return string|null
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * @param string|null $location
     */
    public function setLocation(?string $location): void
    {
        $this->location = $location;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     */
    public function setAddress(?string $address): void
    {
        $this->address = $address;
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
     * @return string|null
     */
    public function getPaymentUrl(): ?string
    {
        return $this->paymentUrl;
    }

    /**
     * @param string|null $paymentUrl
     */
    public function setPaymentUrl(?string $paymentUrl): void
    {
        $this->paymentUrl = $paymentUrl;
    }


}
