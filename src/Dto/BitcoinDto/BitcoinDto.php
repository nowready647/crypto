<?php

declare(strict_types=1);

namespace App\Dto\BitcoinDto;

use DateTimeImmutable;

final class BitcoinDto
{
    public function __construct(
        private DateTimeImmutable $updated,
        private float $usdRate,
        private float $eurRate,
    ) {}

    public function getUpdated(): DateTimeImmutable
    {
        return $this->updated;
    }

    public function getUsdRate(): float
    {
        return $this->usdRate;
    }

    public function getEurRate(): float
    {
        return $this->eurRate;
    }

    public function setEurRate(float $rate): float
    {
        return $this->eurRate = $rate;
    }

    public function setUsdRate(float $rate): float
    {
        return $this->usdRate = $rate;
    }

    public function setUpdated(DateTimeImmutable $updated): DateTimeImmutable
    {
        return $this->updated = $updated;
    }

}