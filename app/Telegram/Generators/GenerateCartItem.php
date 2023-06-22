<?php
/**
 * Description of GenerateCartItem.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Telegram\Generators;


use App\Services\Dots\DotsService;
use Longman\TelegramBot\Entities\Message;

class GenerateCartItem
{
    public function __construct(
        private readonly DotsService $dotsService
    )
    {
    }

    public function generate(Message $message)
    {
        $dish = $this->dotsService->findDishByName($message->getText(true));
        if (!$dish) {
            throw new \LogicException('Dish is required');
        }

        return [
            'id' => $dish['id'],
            'name' => $dish['name'],
            'price' => $dish['price'],
        ];
    }

}
