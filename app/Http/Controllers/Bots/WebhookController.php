<?php

namespace App\Http\Controllers\Bots;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Longman\TelegramBot\Telegram;

class WebhookController extends Controller
{
    public function __construct(
        private readonly Telegram $telegramBot
    )
    {
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
        Log::info('Info webhook: ' . 'https://api.telegram.org/bot' . config('telegram.bot.api_token') . '/setWebhook?url=' . config('telegram.bot.webhook_url'));
        $this->telegramBot->setWebhook('https://api.telegram.org/bot' . config('telegram.bot.api_token') . '/setWebhook?url=' . config('telegram.bot.webhook_url'));
    }
}
