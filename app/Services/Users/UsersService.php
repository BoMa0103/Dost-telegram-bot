<?php

namespace App\Services\Users;

use App\Models\User;
use App\Services\Users\DTO\UserDTO;
use App\Services\Users\Handlers\CreateUserHandler;
use App\Services\Users\Handlers\UpdateUserHandler;
use App\Services\Users\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;

class UsersService
{
    public function __construct(
        private readonly CreateUserHandler $createUserHandler,
        private readonly UpdateUserHandler $updateUserHandler,
        private readonly UserRepository $userRepository
    )
    {
    }

    /**
     * @param int $telegramUserId
     * @return User|null
     */
    public function findUserByTelegramId(int $telegramUserId): ?User
    {
        return $this->userRepository->findByTelegramId($telegramUserId);
    }

    /**
     * @return Collection
     */
    public function getTelegramAdmins(): Collection
    {
        return $this->userRepository->getTelegramAdmins();
    }

    /**
     * @param UserDTO $userDTO
     * @return User
     */
    public function createUser(UserDTO $userDTO): User
    {
        return $this->createUserHandler->handle($userDTO);
    }

    /**
     * @param User $user
     * @param array $data
     * @return User
     */
    public function updateUser(User $user, array $data): User
    {
        return $this->updateUserHandler->handle($user, $data);
    }
}
