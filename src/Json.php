<?php

namespace Crwlr\Utils;

use Crwlr\Utils\Exceptions\InvalidJsonException;

class Json
{
    /**
     * @param string $string
     * @return mixed[]
     * @throws InvalidJsonException
     */
    public static function stringToArray(string $string): array
    {
        $array = json_decode($string, true);

        if (!is_array($array)) {
            $array = json_decode(self::fixJsonString($string), true);

            if (!is_array($array)) {
                throw new InvalidJsonException('Failed to decode JSON string.');
            }
        }

        return $array;
    }

    /**
     * Try to fix JSON keys without quotes
     *
     * PHPs json_decode() doesn't work with JSON objects where the keys are not wrapped in quotes.
     * This method tries to fix this, when json_decode() fails to parse a JSON string.
     */
    protected static function fixJsonString(string $jsonString): string
    {
        return preg_replace_callback(
            '/(?:(\w+):(\s*".*?"\s*(?:,|}))|(\w+):(\s*[^"]+?\s*(?:,|})))/i',
            function ($match) {
                if (count($match) === 3) {
                    $key = $match[1];

                    $value = $match[2];
                } elseif (count($match) === 5) {
                    $key = $match[3];

                    $value = $match[4];
                } else {
                    return $match[0];
                }

                if (!str_starts_with($key, '"')) {
                    $key = '"' . $key;
                }

                if (!str_ends_with($key, '"')) {
                    $key = $key . '"';
                }

                return $key . ':' . $value;
            },
            $jsonString
        ) ?? $jsonString;
    }
}
