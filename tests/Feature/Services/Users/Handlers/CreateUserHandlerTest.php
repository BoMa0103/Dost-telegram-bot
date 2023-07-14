<?php

namespace Tests\Feature\Services\Users\Handlers;

use App\Services\Users\Handlers\CreateUserHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Generators\UserGenerator;
use Tests\TestCase;

class CreateUserHandlerTest extends TestCase
{
    use RefreshDatabase;
    private function getCreateUserHandler(): CreateUserHandler
    {
        return app()->make(CreateUserHandler::class);
    }

    public function testHandle()
    {
        $createUserHandler = $this->getCreateUserHandler();

        $userDTO = UserGenerator::generate();

        $user = $createUserHandler->handle($userDTO);

        $this->assertNotNull($user);
        $this->assertDatabaseCount('users', 1);
    }
}
