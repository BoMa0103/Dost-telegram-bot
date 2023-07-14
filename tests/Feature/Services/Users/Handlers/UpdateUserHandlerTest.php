<?php

namespace Tests\Feature\Services\Users\Handlers;

use App\Services\Users\Handlers\CreateUserHandler;
use App\Services\Users\Handlers\UpdateUserHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Generators\UserGenerator;
use Tests\TestCase;

class UpdateUserHandlerTest extends TestCase
{
    use RefreshDatabase;

    private function getUpdateUserHandler(): UpdateUserHandler
    {
        return app()->make(UpdateUserHandler::class);
    }

    private function getCreateUserHandler(): CreateUserHandler
    {
        return app()->make(CreateUserHandler::class);
    }

    public function testHandle()
    {
        $updateUserHandler = $this->getUpdateUserHandler();

        $createUserHandler = $this->getCreateUserHandler();

        $userDTO = UserGenerator::generate();

        $user = $createUserHandler->handle($userDTO);

        $this->assertDatabaseCount('users', 1);

        $updateUserDTO = UserGenerator::generate();

        $updatedUser = $updateUserHandler->handle($user, [
            'name' => $updateUserDTO->getName(),
        ]);

        $this->assertNotNull($updatedUser);
        $this->assertEquals($updateUserDTO->getName(), $updatedUser->name);
        $this->assertEquals($user->phone, $updatedUser->phone);
        $this->assertDatabaseCount('users', 1);
    }
}
