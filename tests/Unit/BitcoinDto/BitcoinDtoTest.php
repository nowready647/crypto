<?php

declare(strict_types=1);

namespace App\Tests\Unit\BitcoinDto;

use App\Dto\BitcoinDto\BitcoinDto;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BitcoinDtoTest extends KernelTestCase
{
    public function testCreateBitcoinDto(): void {
        self::bootKernel();

        $bitcoinDto = new BitcoinDto(
            updated: new DateTimeImmutable(),
            usdRate: 4567.32,
            eurRate: 1234.57,
        );

        $this->assertIsFloat(actual: $bitcoinDto->getEurRate());
        $this->assertIsFloat(actual: $bitcoinDto->getUsdRate());

        $this->assertEquals(expected: 1234.57, actual: $bitcoinDto->getEurRate());
        $this->assertEquals(expected: 4567.32, actual: $bitcoinDto->getUsdRate());
        $this->assertEquals(
            expected: (new DateTimeImmutable())->format('d.m.Y'),
            actual: $bitcoinDto->getUpdated()->format('d.m.Y'),
        );
    }
}