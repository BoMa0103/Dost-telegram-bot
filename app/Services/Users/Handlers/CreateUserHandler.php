<?php

namespace App\Services\Users\Handlers;

use App\Models\User;
use App\Services\Users\DTO\UserDTO;
use App\Services\Users\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateUserHandler
{
    public function __construct(
        private readonly UserRepository $userRepository
    )
    {
    }

    /**
     * @param UserDTO $userDTO
     * @return User
     */
    public function handle(UserDTO $userDTO): User
    {
//        if (!isset($data['password'])) {
//            $data['password'] = Str::random(32);
//        }
//
//        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->createFromArray($userDTO->toArray());
    }
}
