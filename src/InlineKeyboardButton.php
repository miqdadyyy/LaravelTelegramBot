<?php

namespace Miqdadyyy\LaravelTelegramBot;

use Illuminate\Database\Eloquent\Model;

class InlineKeyboardButton
{
    public function __construct($text, $callback)
    {
        $this->text = $text;
        if (filter_var($callback, FILTER_VALIDATE_URL)) {
            $this->url = $callback;
        } else {
            $this->callback_data = $callback;
        }
    }

    public function __toString()
    {
        return json_encode((array)$this);
    }
}