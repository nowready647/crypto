<?php

declare(strict_types=1);

namespace App\Tests\Unit\BitcoinDto;

use App\Dto\BitcoinDto\BitcoinDto;
use App\Dto\BitcoinDto\BitcoinDtoFactory;
use DateTimeImmutable;
use Exception;
use Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BitcoinDtoFactoryTest extends KernelTestCase
{
    /**
     * @return void
     * @throws Exception
     * @dataProvider positiveDataProvider
     */
    public function testCreateBitcoinDtoFromFactory($data): void {
        self::bootKernel();

        $bitcoinDto = BitcoinDtoFactory::createBitcoinDto(
            response: $data
        );

        $this->assertIsFloat(actual: $bitcoinDto->getEurRate());
        $this->assertIsFloat(actual: $bitcoinDto->getUsdRate());

        $this->assertEquals(expected: 567.42, actual: $bitcoinDto->getEurRate());
        $this->assertEquals(expected: 123.57, actual: $bitcoinDto->getUsdRate());
        $this->assertEquals(
            expected: (new DateTimeImmutable())->format('d.m.Y'),
            actual: $bitcoinDto->getUpdated()->format('d.m.Y'),
        );
    }

    public function positiveDataProvider(): Generator {
        yield 'data' => [
            [
                'time' => [
                    'updated' => 'Nov 8, 2023 17:54:00 UTC',
                ],
                'bpi' => [
                    'USD' => [
                        'rate_float' => 123.567
                    ],
                    'EUR' => [
                        'rate_float' => 567.421
                    ]
                ]
            ]
        ];
    }

    /**
     * @return void
     * @throws Exception
     * @dataProvider negativeDataProvider
     */
    public function testCreateBitcoinDtoFromFactoryException($data): void {
        self::bootKernel();
        $this->expectException(exception: Exception::class);
        $this->expectExceptionMessage(message: 'Wrong data input.');

        BitcoinDtoFactory::createBitcoinDto(
            response: $data
        );
    }

    public function negativeDataProvider(): Generator {
        yield 'withoutTime' => [
            [
                'bpi' => [
                    'USD' => [
                        'rate_float' => 123.567
                    ],
                    'EUR' => [
                        'rate_float' => 567.421
                    ]
                ]
            ]
        ];

        yield 'withoutUsd' => [
            [
                'time' => [
                    'updated' => 'Nov 8, 2023 17:54:00 UTC',
                ],
                'bpi' => [
                    'EUR' => [
                        'rate_float' => 567.421
                    ],
                ]
            ]
        ];

        yield 'withoutEur' => [
            [
                'time' => [
                    'updated' => 'Nov 8, 2023 17:54:00 UTC',
                ],
                'bpi' => [
                    'USD' => [
                        'rate_float' => 123.567
                    ],
                ]
            ]
        ];
    }
}