<?php

namespace Tests\Feature\Services\Users;

use App\Services\Users\UsersService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nette\Utils\Random;
use Tests\Generators\UserGenerator;
use Tests\TestCase;

class UsersServiceTest extends TestCase
{
    use RefreshDatabase;

    private function getUserService(): UsersService
    {
        return app()->make(UsersService::class);
    }

    public function testCreateUser()
    {
        $userDTO = UserGenerator::generate();

        $userService = $this->getUserService();

        $this->assertNull($userService->findUserByTelegramId($userDTO->getTelegramId()));

        $user = $userService->createUser($userDTO);

        $this->assertNotNull($userService->findUserByTelegramId($user->telegram_id));
    }

    public function testUpdateUser()
    {
        $userDTO = UserGenerator::generate();

        $userService = $this->getUserService();

        $user = $userService->createUser($userDTO);

        $this->assertNotNull($userService->findUserByTelegramId($user->telegram_id));

        $userDTO->setName(Random::generate(10, 'a-z'));

        $this->assertNotEquals($userService->findUserByTelegramId($user->telegram_id)->name, $userDTO->getName());

        $user = $userService->updateUser($user, $userDTO->toArray());

        $this->assertEquals($userService->findUserByTelegramId($user->telegram_id)->name, $userDTO->getName());
    }
}
