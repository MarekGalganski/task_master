<?php


namespace App\Utils;


class RandomGenerator
{
    public static function generateColor(): string
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }
}
