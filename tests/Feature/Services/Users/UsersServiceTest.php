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
        $data = UserGenerator::generate();

        $userService = $this->getUserService();

        $this->assertNull($userService->findUserByTelegramId($data['telegram_id']));

        $user = $userService->createUser($data);

        $this->assertNotNull($userService->findUserByTelegramId($user->telegram_id));
    }

    public function testUpdateUser()
    {
        $data = UserGenerator::generate();

        $userService = $this->getUserService();

        $user = $userService->createUser($data);

        $this->assertNotNull($userService->findUserByTelegramId($user->telegram_id));

        $data['name'] = Random::generate(10, 'a-z');

        $this->assertNotEquals($userService->findUserByTelegramId($user->telegram_id)->name, $data['name']);

        $user = $userService->updateUser($user, $data);

        $this->assertEquals($userService->findUserByTelegramId($user->telegram_id)->name, $data['name']);
    }
}
