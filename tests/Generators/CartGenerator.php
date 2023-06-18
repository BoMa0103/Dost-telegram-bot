<?php

namespace Tests\Generators;

use App\Services\Cart\DTO\CartDTO;
use Nette\Utils\Random;

class CartGenerator
{

    public static function generate(): CartDTO
    {
        $cartKey = md5(Random::generate(9));

        $data = [
            'key' => $cartKey,
            'items' => [[
                'dish_id' => md5(Random::generate(10, 'a-z')),
                'name' => Random::generate(10, 'a-z'),
                'price' => Random::generate(3, '1-9'),
                'count' => Random::generate(3, '1-9')
                ]],
            'user' => [
                'id' => Random::generate(9, '1-9'),
                'name' => Random::generate(10, 'a-z'),
                'phone' => Random::generate(9, '1-9'),
            ],
            'company_id' => md5(Random::generate(10, 'a-z')),
            'city_id' => md5(Random::generate(10, 'a-z')),
        ];
        return CartDTO::fromArray($data);
    }

    public static function generateItem(): array
    {
        return [
            'dish_id' => md5(Random::generate(10, 'a-z')),
            'name' => Random::generate(10, 'a-z'),
            'price' => Random::generate(3, '1-9'),
            'count' => Random::generate(3, '1-9')
        ];
    }

}
