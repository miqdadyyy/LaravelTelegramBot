<?php

namespace Miqdadyyy\LaravelTelegramBot;

use Illuminate\Database\Eloquent\Model;

class InlineKeyboard
{
    public $rows;

    public function __construct()
    {
        $this->rows = [];
    }

    public static function createSingleButton($text, $callback)
    {
        return (new InlineKeyboard())->addSingleLineButton($text, $callback);
    }

    public function addRow(InlineKeyboardRow $row)
    {
        array_push($this->rows, $row);
    }

    public function addSingleLineButton($text, $callback)
    {
        $row = new InlineKeyboardRow();
        $row->addButton($text, $callback);
        array_push($this->rows, $row);
        return $this;
    }

    public function render()
    {
        $res = [];
        foreach ($this->rows as $row) {
            array_push($res, $row->buttons);
        }
        return json_encode([
            'inline_keyboard' => $res
        ]);
    }

    public function __toString()
    {
        return json_encode($this);
    }
}