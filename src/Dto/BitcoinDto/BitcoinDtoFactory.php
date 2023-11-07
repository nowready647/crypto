<?php

declare(strict_types=1);

namespace App\Dto\BitcoinDto;

use DateTimeImmutable;
use DateTimeZone;
use Exception;

final class BitcoinDtoFactory
{
    public static function createBitcoinDto(array $response): BitcoinDto
    {
        if (
            count($response) === 0 ||
            !array_key_exists('time', $response) ||
            !array_key_exists('updated', $response['time']) ||
            !array_key_exists('bpi', $response) ||
            !array_key_exists('USD', $response['bpi']) ||
            !array_key_exists('EUR', $response['bpi'])
        ) {
            throw new Exception(message: 'Wrong data input.');
        }

        return new BitcoinDto(
            updated: (new DateTimeImmutable($response['time']['updated']))
                ->setTimezone(new DateTimeZone('Europe/Prague')),
            usdRate: round(num: $response['bpi']['USD']['rate_float'], precision: 2),
            eurRate: round(num: $response['bpi']['EUR']['rate_float'], precision: 2),
        );
    }

}