<?php

namespace Tests\Feature\Services\Cart;

use App\Services\Cart\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nette\Utils\Random;
use Tests\Generators\CartGenerator;
use Tests\TestCase;

class CartServiceTest extends TestCase
{

    use RefreshDatabase;

    private function getCartService(): CartService
    {
        return app()->make(CartService::class);
    }

    public function testGetOrCreateCart()
    {
        $cart = CartGenerator::generate();

        $cartService = $this->getCartService();

        $this->assertEquals($cartService->getOrCreateCart($cart->getKey(), $cart->toArray())->getUser(), $cart->getUser());
        $this->assertEquals($cartService->getOrCreateCart($cart->getKey(), $cart->toArray())->getItems(), $cart->getItems());
        $this->assertEquals($cartService->getOrCreateCart($cart->getKey(), $cart->toArray())->getCompanyId(), $cart->getCompanyId());
        $this->assertEquals($cartService->getOrCreateCart($cart->getKey(), $cart->toArray())->getCityId(), $cart->getCityId());
    }

    public function testAddItemToCart()
    {
        $cart = CartGenerator::generate();
        $cartItem = CartGenerator::generateItem();

        $cartService = $this->getCartService();

        $this->assertEquals($cartService->getOrCreateCart($cart->getKey(), $cart->toArray())->getItemsArray(), $cart->getItemsArray());

        $cartService->addItem($cart, $cartItem);
        $cartService->addItem($cart, $cartItem);

        $this->assertEquals($cartService->getOrCreateCart($cart->getKey(), $cart->toArray())->getItems(), $cart->getItems());

    }

    public function testSetCompanyId()
    {
        $cart = CartGenerator::generate();

        $cartService = $this->getCartService();

        $companyId = md5(Random::generate(10, 'a-z'));

        $this->assertEquals($cartService->getOrCreateCart($cart->getKey(), $cart->toArray())->getCompanyId(), $cart->getCompanyId());

        $cartService->setCompanyId($cart, $companyId);

        $this->assertEquals($cartService->getOrCreateCart($cart->getKey(), $cart->toArray())->getCompanyId(), $companyId);
    }

    public function testSetCityId()
    {
        $cart = CartGenerator::generate();

        $cartService = $this->getCartService();

        $cityId = md5(Random::generate(10, 'a-z'));

        $this->assertEquals($cartService->getOrCreateCart($cart->getKey(), $cart->toArray())->getCityId(), $cart->getCityId());

        $cartService->setCityId($cart, $cityId);

        $this->assertEquals($cartService->getOrCreateCart($cart->getKey(), $cart->toArray())->getCityId(), $cityId);
    }

}
