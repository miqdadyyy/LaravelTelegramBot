<?php

namespace Miqdadyyy\LaravelTelegramBot;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    public function __toString()
    {
        return json_encode((array)$this);
    }
}