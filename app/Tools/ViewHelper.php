<?php

namespace App\Tools;


class ViewHelper
{
    public static function checked($value)
    {
        return $value ? 'checked' : '';
    }
}