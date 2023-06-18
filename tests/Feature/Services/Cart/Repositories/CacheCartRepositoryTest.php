<?php

namespace Tests\Feature\Services\Cart\Repositories;

use App\Services\Cart\Repositories\CacheCartRepository;
use Tests\Generators\CartGenerator;
use Tests\TestCase;

class CacheCartRepositoryTest extends TestCase
{
    private function getCartRepository(): CacheCartRepository
    {
        return app()->make(CacheCartRepository::class);
    }

    public function testStoreCartToCache()
    {
        $cart = CartGenerator::generate();

        $cartRepository = $this->getCartRepository();

        $this->assertNull($cartRepository->findByKey($cart->getKey()), 'variable is null');

        $cartRepository->store($cart);

        $this->assertNotNull($cartRepository->findByKey($cart->getKey()), 'variable is not null');
        $this->assertEquals($cartRepository->findByKey($cart->getKey())->getCompanyId(), $cart->getCompanyId());
    }

    public function testClearItemsAtCart()
    {
        $cart = CartGenerator::generate();

        $cartRepository = $this->getCartRepository();

        $cartRepository->store($cart);

        $this->assertNotEquals($cartRepository->findByKey($cart->getKey())->getItems(), []);
        $this->assertEquals($cartRepository->findByKey($cart->getKey())->getItems(), $cart->getItems());

        $cartRepository->clearItems($cart);

        $this->assertEquals($cartRepository->findByKey($cart->getKey())->getItems(), []);
    }

    public function testClearCompanyAtCart()
    {
        $cart = CartGenerator::generate();

        $cartRepository = $this->getCartRepository();

        $cartRepository->store($cart);

        $this->assertNotEquals($cartRepository->findByKey($cart->getKey())->getCompanyId(), ' ');
        $this->assertEquals($cartRepository->findByKey($cart->getKey())->getCompanyId(), $cart->getCompanyId());

        $cartRepository->clearCompany($cart);

        $this->assertEquals($cartRepository->findByKey($cart->getKey())->getCompanyId(), ' ');
    }

    public function testClearCityAtCart()
    {
        $cart = CartGenerator::generate();

        $cartRepository = $this->getCartRepository();

        $cartRepository->store($cart);

        $this->assertNotEquals($cartRepository->findByKey($cart->getKey())->getCityId(), ' ');
        $this->assertEquals($cartRepository->findByKey($cart->getKey())->getCityId(), $cart->getCityId());

        $cartRepository->clearCity($cart);

        $this->assertEquals($cartRepository->findByKey($cart->getKey())->getCityId(), ' ');
    }


}
