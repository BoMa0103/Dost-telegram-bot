<?php

namespace Tests\Feature\Services\Cart\Repositories;

use App\Services\Cart\Repositories\CacheCartRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Generators\CartGenerator;
use Tests\TestCase;

class CacheCartRepositoryTest extends TestCase
{
    use RefreshDatabase;

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

    public function testClearItems()
    {
        $cart = CartGenerator::generate();

        $cartRepository = $this->getCartRepository();

        $cartRepository->store($cart);

        $this->assertNotEquals([], $cartRepository->findByKey($cart->getKey())->getItems());
        $this->assertEquals($cartRepository->findByKey($cart->getKey())->getItems(), $cart->getItems());

        $cartRepository->clearItems($cart);

        $this->assertEquals([], $cartRepository->findByKey($cart->getKey())->getItems());
    }

    public function testClearCompany()
    {
        $cart = CartGenerator::generate();

        $cartRepository = $this->getCartRepository();

        $cartRepository->store($cart);

        $this->assertNotEquals(' ', $cartRepository->findByKey($cart->getKey())->getCompanyId());
        $this->assertEquals($cartRepository->findByKey($cart->getKey())->getCompanyId(), $cart->getCompanyId());

        $cartRepository->clearCompany($cart);

        $this->assertEquals(' ', $cartRepository->findByKey($cart->getKey())->getCompanyId());
    }

    public function testClearCity()
    {
        $cart = CartGenerator::generate();

        $cartRepository = $this->getCartRepository();

        $cartRepository->store($cart);

        $this->assertNotEquals(' ', $cartRepository->findByKey($cart->getKey())->getCityId());
        $this->assertEquals($cartRepository->findByKey($cart->getKey())->getCityId(), $cart->getCityId());

        $cartRepository->clearCity($cart);

        $this->assertEquals(' ', $cartRepository->findByKey($cart->getKey())->getCityId());
    }

    public function testClearCompanyAddress()
    {
        $cart = CartGenerator::generate();

        $cartRepository = $this->getCartRepository();

        $cartRepository->store($cart);

        $this->assertNotEquals(' ', $cartRepository->findByKey($cart->getKey())->getCompanyAddressId());

        $cartRepository->clearCompanyAddressId($cartRepository->findByKey($cart->getKey()));

        $this->assertEquals(' ', $cartRepository->findByKey($cart->getKey())->getCompanyAddressId());
    }

    public function testClearDeliveryType()
    {
        $cart = CartGenerator::generate();

        $cartRepository = $this->getCartRepository();

        $cartRepository->store($cart);

        $this->assertNotEquals(-1,  $cartRepository->findByKey($cart->getKey())->getDeliveryType());

        $cartRepository->clearDeliveryType($cartRepository->findByKey($cart->getKey()));

        $this->assertEquals(-1, $cartRepository->findByKey($cart->getKey())->getDeliveryType());
    }

    public function testClearDeliveryAddressStreet()
    {
        $cart = CartGenerator::generate();

        $cartRepository = $this->getCartRepository();

        $cartRepository->store($cart);

        $this->assertNotEquals(' ', $cartRepository->findByKey($cart->getKey())->getDeliveryAddressStreet());

        $cartRepository->clearDeliveryAddressStreet($cartRepository->findByKey($cart->getKey()));

        $this->assertEquals(' ', $cartRepository->findByKey($cart->getKey())->getDeliveryAddressStreet());
    }

    public function testClearDeliveryAddressHouse()
    {
        $cart = CartGenerator::generate();

        $cartRepository = $this->getCartRepository();

        $cartRepository->store($cart);

        $this->assertNotEquals(' ', $cartRepository->findByKey($cart->getKey())->getDeliveryAddressHouse());

        $cartRepository->clearDeliveryAddressHouse($cartRepository->findByKey($cart->getKey()));

        $this->assertEquals(' ', $cartRepository->findByKey($cart->getKey())->getDeliveryAddressHouse());
    }

}
