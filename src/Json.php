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
     * Try to fix an invalid JSON string
     *
     * 1) Try to fix JSON keys without quotes
     * PHPs json_decode() doesn't work with JSON objects where the keys are not wrapped in quotes.
     * This method tries to fix this, when json_decode() fails to parse a JSON string.
     *
     * 2) Try to fix unescaped double quotes within a string value
     */
    protected static function fixJsonString(string $jsonString): string
    {
        $jsonString = preg_replace_callback(
            '/(?:(\w+):(\s*".*?"\s*(?:,|}))|(\w+):(\s*[^"]+?\s*(?:,|})))/i',
            function ($match) {
                if (count($match) === 3) {
                    $key = $match[1];

                    $value = $match[2];
                } else {
                    $key = $match[3];

                    $value = $match[4];
                }

                if (!str_starts_with($key, '"')) {
                    $key = '"' . $key;
                }

                if (!str_ends_with($key, '"')) {
                    $key = $key . '"';
                }

                return $key . ':' . $value;
            },
            $jsonString,
        ) ?? $jsonString;

        // If JSON string contains unescaped double quotes inside a string value, try to fix it.
        if (preg_match('/"[^",}]*?":\s*?"((?:[^",}]*?(?<!\\\\)")+[^"]*?)"\s*?(,|})/', $jsonString)) {
            $jsonString = preg_replace_callback(
                '/"[^",}]*?":\s*?"((?:[^",}]*?(?<!\\\\)")+[^"]*?)"\s*?(,|})/',
                function ($match) {
                    return str_replace(
                        $match[1],
                        str_replace('"', '\"', $match[1]),
                        $match[0],
                    );
                },
                $jsonString,
            ) ?? $jsonString;
        }

        return $jsonString;
    }
}
