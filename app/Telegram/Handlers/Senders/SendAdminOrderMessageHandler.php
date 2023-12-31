<?php


namespace App\Telegram\Handlers\Senders;

use App\Models\Order;
use App\Models\User;
use App\Services\Users\UsersService;
use App\Telegram\Generators\OrderMessageGenerator;
use Illuminate\Database\Eloquent\Collection;

class SendAdminOrderMessageHandler
{
    public function __construct(
        private readonly OrderMessageGenerator $orderMessageGenerator,
        private readonly UsersService $usersService,
        private readonly SendMessageHandler $sendMessageHandler
    )
    {
    }

    public function handle(Order $order)
    {
        $users = $this->getUsersToNotify();
        $message = $this->orderMessageGenerator->generate($order);
        foreach ($users as $user) {
            $this->sendMessageToUser($user, $message);
        }
    }

    /**
     * @return Collection
     */
    private function getUsersToNotify(): Collection
    {
        return $this->usersService->getTelegramAdmins();
    }

    /**
     * @param User $user
     * @param string $message
     */
    private function sendMessageToUser(User $user, string $message)
    {
        $this->sendMessageHandler->handle($user->telegram_id, $message);
    }
}
