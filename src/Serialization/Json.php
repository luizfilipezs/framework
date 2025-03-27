<?php

namespace Luizfilipezs\Framework\Serialization;

final class Json
{
    public static function encode(mixed $data, int $flags = JSON_UNESCAPED_UNICODE): string
    {
        return json_encode($data, $flags);
    }
}
