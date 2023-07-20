<?php

namespace Crwlr\Utils;

/**
 * Microseconds Value Object
 *
 * As calculating with float values in PHP is very error-prone (see
 * https://medium.com/@dotcom.software/floating-dangers-in-php-c4a2220bd8dc for example), this class internally converts
 * float values (representing seconds) to integers (representing Microseconds) and thereby making it way easier and
 * less error-prone to work with.
 */

class Microseconds
{
    public function __construct(public int $value)
    {
    }

    public static function now(): self
    {
        return self::fromSeconds(microtime(true));
    }

    public static function fromSeconds(float $seconds): self
    {
        return new self((int) ($seconds * 1000000));
    }

    public function add(Microseconds $seconds): Microseconds
    {
        return new Microseconds($this->value + $seconds->value);
    }

    public function subtract(Microseconds $seconds): Microseconds
    {
        return new Microseconds($this->value - $seconds->value);
    }

    public function toSeconds(): float
    {
        return $this->value / 1000000;
    }

    public function equals(Microseconds $seconds): bool
    {
        return $this->value === $seconds->value;
    }

    public function isGreaterThan(Microseconds $seconds): bool
    {
        return $this->value > $seconds->value;
    }

    public function isGreaterThanOrEqual(Microseconds $seconds): bool
    {
        return $this->value >= $seconds->value;
    }

    public function isLessThan(Microseconds $seconds): bool
    {
        return $this->value < $seconds->value;
    }

    public function isLessThanOrEqual(Microseconds $seconds): bool
    {
        return $this->value <= $seconds->value;
    }
}
