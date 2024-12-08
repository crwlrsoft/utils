<?php

namespace Crwlr\Utils;

class PhpVersion
{
    public static function isAtLeast(int $major, ?int $minor = null): bool
    {
        return PHP_MAJOR_VERSION >= $major && ($minor === null || PHP_MINOR_VERSION >= $minor);
    }

    public static function isBelow(int $major, ?int $minor = null): bool
    {
        return !self::isAtLeast($major, $minor);
    }
}
