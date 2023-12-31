<?php

namespace Tests\Generators;

use App\Services\Users\DTO\UserDTO;
use Nette\Utils\Random;
class UserGenerator
{
    public static function generate(): UserDTO
    {
        return self::createUserDTO();
    }

    private static function createUserDTO(): UserDTO
    {
        return UserDTO::fromArray([
            'telegram_id' => Random::generate(9, '0-9'),
            'name' => Random::generate(9, 'a-z'),
            'phone' => Random::generate(9, '0-9'),
            'lang' => Random::generate(2, 'a-z'),
        ]);
    }
}
