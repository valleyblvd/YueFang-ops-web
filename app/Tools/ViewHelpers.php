<?php

namespace App\Tools;


class ViewHelpers
{
    public static function checked($value)
    {
        return $value ? 'checked' : '';
    }
}