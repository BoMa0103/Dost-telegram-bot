<?php

namespace Tests\Feature\Services\Cart\Handlers;

use App\Services\Cart\Handlers\CreateOrderHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Generators\CartGenerator;
use Tests\TestCase;

class CreateOrderHandlerTest extends TestCase
{
    use RefreshDatabase;
    private function getCreateOrderHandler(): CreateOrderHandler
    {
        return app()->make(CreateOrderHandler::class);
    }

    public function testHandle()
    {
        $createOrderHandler = $this->getCreateOrderHandler();

        $chatId = 817109800;

        $cartDTO = CartGenerator::generateRealDish();

        $order = $createOrderHandler->handle($chatId, $cartDTO);

        $this->assertNotNull($order);
    }
}
