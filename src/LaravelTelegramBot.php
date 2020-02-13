<?php

namespace Miqdadyyy\LaravelTelegramBot;

use GuzzleHttp\Client;

class LaravelTelegramBot
{
    use ApiHelper;

    public static function getId(){
        $response = self::request('GET', 'getMe');
        return self::convert($response);
    }

    public static function getUpdates(){
        $response = self::request('GET', 'getUpdates');
        return self::convert($response);
    }

    public static function sendMessage($chat_id, $text, $options = []){
        return self::createMessage($chat_id, $text, $options)->send();
    }

    public static function createMessage($chat_id, $text, $options = []){
        return new Message($chat_id, $text, $options);
    }

    public static function answerCallbackQuery($callback_id, $options = []){
        $req_data = [
            'callback_query_id' => $callback_id
        ];
        foreach ($options as $key => $option){
            $req_data[$key] = $option;
        }
        $response = self::request('POST', 'answerCallbackQuery', $req_data);
        return self::convert($response);
    }
}