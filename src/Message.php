<?php
/**
 * Created by PhpStorm.
 * User: miqdadyyy
 * Date: 2/12/20
 * Time: 9:44 PM
 */

namespace Miqdadyyy\LaravelTelegramBot;


class Message
{
    use ApiHelper;
    /**
     * Message constructor.
     * @param $chat_id
     * @param $message
     */
    public function __construct($chat_id, $text, $options = [])
    {
        $this->chat_id = $chat_id;
        $this->text = $text;
        foreach ($options as $key => $option){
            $this->$key = $option;
        }
    }


    public function addInlineKeyboard(InlineKeyboard $inlineKeyboard){
        $this->reply_markup = $inlineKeyboard;
        return $this;
    }

    public function addSingleInlineButton($text, $callback){
        if(!isset($this->reply_markup)){
            $this->reply_markup = (new InlineKeyboard())->addSingleLineButton($text, $callback);
        } else {
            $this->reply_markup->addSingleLineButton($text, $callback);
        }
        return $this;
    }

    public function setKeyboardButton(array $keyboard){
        if(!isset($this->reply_markup)){
            $this->reply_markup = [
                'keyboard' => $keyboard,
                'resize_keyboard' => true,
                'one_time_keyboard' => true
            ];
        }
        return $this;
    }

    public function send(){
        $data = get_object_vars($this);
        if(isset($this->reply_markup)){
            $data['reply_markup'] = gettype($this->reply_markup) === "array" ? json_encode($this->reply_markup) : $this->reply_markup->render();
        }
        $response = self::request('POST', 'sendMessage', $data);
        return self::convert($response);
    }

    public function __toString()
    {
        return json_encode($this);
    }
}