<?php
/**
 * Description of CartItemDTO.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Cart\DTO;


class CartItemDTO
{
    private function __construct(
        private readonly string $dish_id,
        private readonly string $name,
        private readonly float $price,
        private int $count
    )
    {
    }

    public static function fromArray(array $data)
    {
        return new self(
            $data['dish_id'],
            $data['name'],
            $data['price'] ?? 0,
            $data['count'] ?? 1
        );
    }

    public function toArray(): array
    {
        return [
            'dish_id' => $this->getDishId(),
            'name' => $this->getName(),
            'price' => $this->getPrice(),
            'count' => $this->getCount(),
        ];
    }

    /**
     * @return string
     */
    public function getDishId(): string
    {
        return $this->dish_id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }


    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    public function addCount(): int
    {
        return $this->count++;
    }

}
