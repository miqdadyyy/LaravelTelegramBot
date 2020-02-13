<?php

namespace App\Http\Controllers\TelegramBot;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Miqdadyyy\LaravelTelegramBot\ApiHelper;
use Miqdadyyy\LaravelTelegramBot\LaravelTelegramBot;

class WebhookUpdate extends Controller
{
    use ApiHelper;

    public function retrieveUpdate(Request $request)
    {
        $update = self::extractUpdate(file_get_contents('php://input'));
        // when user send message or command to bot
        if ($update->type === "message") {
            $commands = explode(' ', $update->text);
            switch (strtolower(str_replace('/', '', $commands[0]))) {
                case "login" :
                    {
                        // Save telegram user id
                        break;
                    }
                case "help" :
                    {
                        // Add your available command here
                        $commands = [
                            "/login" => "Authenticate your system to our bot",
                            "/help" => "Show all available command"
                        ];


                        $printable_commands = implode("\n", array_map(
                            function ($v, $k) {
                                return sprintf("%s: %s", $k, $v);
                            },
                            $commands,
                            array_keys($commands)
                        ));;

                        LaravelTelegramBot::createMessage($update->chat_id, "Here is available commands : \n\n$printable_commands", ['parse_mode' => 'html'])->send();
                        break;
                    }

                default :
                    {
                        LaravelTelegramBot::createMessage($update->chat_id, "Sorry, we dont know what you said &#128557;", ['parse_mode' => 'html'])->send();
                    };
            }
        }
        else if ($update->type === "callback_query") { // Add your callback query here (https://core.telegram.org/bots/api#callbackquery)
            // Get data from callback Query
            $data = $update->data;

            // Answer Callback Query
            \Miqdadyyy\LaravelTelegramBot\LaravelTelegramBot::answerCallbackQuery($update->callback_query_id, [
                'text' => 'Ok Callback Success'
            ]);

            // Send Message after Answer Callback
            LaravelTelegramBot::sendMessage($update->chat_id, $data);
        } else {
            // other updates

        }
    }
}