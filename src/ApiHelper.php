<?php

namespace Miqdadyyy\LaravelTelegramBot;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Miqdadyyy\LaravelTelegramBot\Response;

/**
 * Created by PhpStorm.
 * User: miqdadyyy
 * Date: 2/13/20
 * Time: 1:27 AM
 */
trait ApiHelper
{

    protected static function request($method, $endpoint, $params = [])
    {
        $url = config('laraveltelegrambot.base_url') . 'bot' . config('laraveltelegrambot.api_key');
        $client = new Client();
        $response = $client->request($method, $url . "/$endpoint", [
            'form_params' => $params
        ]);

        return $response->getBody()->getContents();
    }

    protected static function convert($data)
    {
        $data = json_decode($data);
        $result = (new Response())->forceFill((array)$data);
        foreach ($data as $index => $d) {
            if (gettype($d) === 'object') {
                $result->$index = self::convert(json_encode($d));
            }
        }
        return $result;
    }

    protected static function extractUpdate($input){
        $res = self::convert($input);
        if(!is_null($res->message)){
            return (new Response())->forceFill([
                'type' => 'message',
                'update_id' => $res->update_id,
                'name' => $res->message->from->first_name . ' ' . $res->message->from->last_name,
                'chat_id' => $res->message->from->id,
                'date' => Carbon::parse($res->message->date),
                'text' => $res->message->text
            ]);
        } else if(!is_null($res->callback_query)){
            return (new Response())->forceFill([
                'type' => 'callback_query',
                'callback_query_id' => $res->callback_query->id,
                'update_id' => $res->update_id,
                'name' => $res->callback_query->from->first_name . ' ' . $res->callback_query->from->last_name,
                'chat_id' => $res->callback_query->from->id,
                'data' => $res->callback_query->data
            ]);
        }
    }
}