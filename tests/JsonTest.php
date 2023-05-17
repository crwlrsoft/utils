<?php

use Crwlr\Utils\Exceptions\InvalidJsonException;
use Crwlr\Utils\Json;

it('converts a valid JSON string to an array', function () {
    $jsonString = <<<JSON
        {
            "foo": "one",
            "bar": 2,
            "baz": ["three", true, 5.1]
        }
        JSON;

    expect(Json::stringToArray($jsonString))->toBe([
        'foo' => 'one',
        'bar' => 2,
        'baz' => ['three', true, 5.1],
    ]);
});

it('works with JS style JSON objects without quotes around keys', function () {
    $jsonString = <<<JSON
        {
            foo: "one",
            bar: "two",
            "baz": "three"
        }
        JSON;

    expect(Json::stringToArray($jsonString))->toBe(['foo' => 'one', 'bar' => 'two', 'baz' => 'three']);
});

it('correctly fixes keys without quotes, even when values contain colons', function () {
    $jsonString = <<<JSON
        {
            foo: "https://www.example.com",
            bar: 2,
            "baz": "some: thing"
        }
        JSON;

    expect(Json::stringToArray($jsonString))->toBe([
        'foo' => 'https://www.example.com',
        'bar' => 2,
        'baz' => 'some: thing',
    ]);
});

it('correctly fixes keys without quotes, when the value is an empty string', function () {
    $jsonString = <<<JSON
        {
            foo: "",
            "bar": "baz"
        }
        JSON;

    expect(Json::stringToArray($jsonString))->toBe([
        'foo' => '',
        'bar' => 'baz',
    ]);
});

it('throws an exception when the string is not a (valid) JSON string', function () {
    Json::stringToArray('{ foo: bar ]');
})->throws(InvalidJsonException::class);
