<?php

namespace Tests\Generators;

use App\Services\Cart\DTO\CartDTO;
use App\Services\Dots\DotsService;
use Illuminate\Support\Facades\Log;
use Nette\Utils\Random;

class CartGenerator
{
    private static function getDotsService(): DotsService
    {
        return app()->make(DotsService::class);
    }

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
            'company_address_id' => md5(Random::generate(9)),
            'delivery_type' => Random::generate(1, '1-5'),
            'delivery_address_street' => Random::generate(10, 'a-z'),
            'delivery_address_house' => Random::generate(10, 'a-z'),
        ];
        return CartDTO::fromArray($data);
    }

    public static function generateRealDish(): CartDTO
    {
        $dotsService = self::getDotsService();
        $cities = $dotsService->getCities();
        $cityId = $cities['items'][0]['id'];
        $companies = $dotsService->getCompanies($cityId);
        $companyId = $companies['items'][0]['id'];
        $dishes = $dotsService->getDishes($companyId);
        $dishCategories = $dishes['items'][0];
        $dish = $dishCategories['items'][0];

        $cartKey = md5(Random::generate(9));

        $data = [
            'key' => $cartKey,
            'items' => [[
                'dish_id' => $dish['id'],
                'name' => $dish['name'],
                'price' => $dish['price'],
                'count' => Random::generate(1, '1-9')
            ]],
            'user' => [
                'id' => Random::generate(9, '1-9'),
                'name' => Random::generate(10, 'a-z'),
                'phone' => Random::generate(9, '1-9'),
            ],
            'company_id' => $companyId,
            'city_id' => $cityId,
            'company_address_id' => $dotsService->getCompanyInfo($companyId)['addresses'][0]['id'],
            'delivery_type' => 2,
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
