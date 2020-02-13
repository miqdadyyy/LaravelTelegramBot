<?php

namespace Miqdadyyy\LaravelTelegramBot;

use Illuminate\Database\Eloquent\Model;

class InlineKeyboardRow
{
    public $buttons;

    public function __construct()
    {
        $this->buttons = [];
    }

    public function addButton(...$options)
    {
        $options = collect($options);
        if (gettype($options->first()) === 'string' && $options->count() > 1) {
            $button = new InlineKeyboardButton(...$options);
        } else if (strpos(get_class($options->first()), 'InlineKeyboardButton') !== false) {
            $button = $options->first();
        } else {
            throw new \Exception("Parameter should be 2 string (text and callback/url) or InlineKeyboardButton Instance");
        }

        array_push($this->buttons, $button);
        return $this;
    }

    public function __toString()
    {
        return json_encode($this);
    }


}