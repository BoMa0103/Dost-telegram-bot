<?php

namespace App\Http\Controllers\Bots;

use App\Http\Controllers\Controller;
use Longman\TelegramBot\Telegram;

class WebhookController extends Controller
{
    /** @var Telegram  */
    private $telegramBot;

    public function __construct(
        Telegram $telegramBot
    )
    {
        $this->telegramBot = $telegramBot;
    }
    /**
     * Handle the incoming request.
     */
    public function updates()
    {
        return $this->telegramBot->handle();
    }

    public function setWebhook()
    {
        $this->telegramBot->setWebhook('https://api.telegram.org/bot' . config('telegram.bot.api_token') . '/setWebhook?url=' . config('telegram.bot.webhook_url'));
    }
}
