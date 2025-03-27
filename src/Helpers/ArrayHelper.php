<?php

namespace Luizfilipezs\Framework\Helpers;

final class ArrayHelper
{
    public static function isAssociative(array $array): bool
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }
}
