<?php

namespace Tests\Feature\Services\Users\Repositories;

use App\Services\Users\Handlers\CreateUserHandler;
use App\Services\Users\Repositories\EloquentUserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Generators\UserGenerator;
use Tests\TestCase;

class EloquentUserRepositoryTest extends TestCase
{
    use RefreshDatabase;
    private function getEloquentUserRepository(): EloquentUserRepository
    {
        return app()->make(EloquentUserRepository::class);
    }
    private function getCreateUserHandler(): CreateUserHandler
    {
        return app()->make(CreateUserHandler::class);
    }

    public function testFind()
    {
        $createUserHandler = $this->getCreateUserHandler();

        $userDTO = UserGenerator::generate();

        $user = $createUserHandler->handle($userDTO);

        $eloquentUserRepository = $this->getEloquentUserRepository();

        $foundUser = $eloquentUserRepository->find($user->id);

        $this->assertNotNull($foundUser);
        $this->assertEquals($foundUser->name, $user->name);
    }

    public function testFindByTelegramId()
    {
        $createUserHandler = $this->getCreateUserHandler();

        $userDTO = UserGenerator::generate();

        $user = $createUserHandler->handle($userDTO);

        $eloquentUserRepository = $this->getEloquentUserRepository();

        $foundUser = $eloquentUserRepository->findByTelegramId($user->telegram_id);

        $this->assertNotNull($foundUser);
        $this->assertEquals($foundUser->name, $user->name);
    }

    public function testGetTelegramAdmins()
    {
        $eloquentUserRepository = $this->getEloquentUserRepository();

        $telegramAdmins = $eloquentUserRepository->getTelegramAdmins();

        $this->assertEmpty($telegramAdmins);
    }

    public function testCreateFromArray()
    {
        $userDTO = UserGenerator::generate();

        $eloquentUserRepository = $this->getEloquentUserRepository();

        $createdUser = $eloquentUserRepository->createFromArray($userDTO->toArray());

        $this->assertNotNull($createdUser);
        $this->assertEquals($createdUser->name, $userDTO->getName());
        $this->assertEquals($createdUser->phone, $userDTO->getPhone());
        $this->assertDatabaseCount('users', 1);
    }

    public function testUpdateFromArray()
    {
        $createUserHandler = $this->getCreateUserHandler();

        $userDTO = UserGenerator::generate();

        $user = $createUserHandler->handle($userDTO);

        $updatedUserDTO = UserGenerator::generate();

        $eloquentUserRepository = $this->getEloquentUserRepository();

        $updatedUser = $eloquentUserRepository->updateFromArray($user, $updatedUserDTO->toArray());

        $this->assertNotNull($updatedUser);
        $this->assertNotEquals($updatedUser->name, $userDTO->getName());
        $this->assertNotEquals($updatedUser->lang, $userDTO->getLang());
        $this->assertNotEquals($updatedUser->phone, $userDTO->getPhone());
        $this->assertEquals($updatedUser->name, $user->name);
        $this->assertEquals($updatedUser->lang, $user->lang);
        $this->assertEquals($updatedUser->phone, $user->phone);
        $this->assertEquals($updatedUser->id, $user->id);
        $this->assertDatabaseCount('users', 1);
    }
}
