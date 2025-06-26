<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;


class TelegramNotification
{
    public static function sendNotification($message)
    {
        // ambil token telegram di env
        $botToken = env('TELEGRAM_BOT_TOKEN');

        // ambil id chat telegram
        $chatId = env('TELEGRAM_CHAT_ID');
        if (!$botToken || !$chatId) {
            return false;
        }

        $url = "https://api.telegram.org/bot{$botToken}/sendMessage";

        try {
            $response =  Http::get($url, [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'Markdown'
            ]);
            return $response->successful();
        } catch (RequestException $err) {
            Log::error('Gagal mengirim notifikasi Telegram: ' . $err->getMessage());
            return false;
        }
    }

    public static function sendOrFail($message)
    {
        if (!self::sendNotification($message)) {
            // otomatis redirect back jika gagal
            back()->with('error', 'Notifikasi Telegram gagal dikirim. Periksa koneksi internet.')->send();
            exit; // pastikan tidak lanjut ke bawah
        }
    }
}
