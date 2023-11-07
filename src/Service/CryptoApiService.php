<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\BitcoinDto\BitcoinDto;
use App\Dto\BitcoinDto\BitcoinDtoFactory;
use PharIo\Version\Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class CryptoApiService
{
    private array $endpoints;

    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly HttpClientInterface   $httpClient,
        ParameterBagInterface $parameterBag,
    ) {
        $this->endpoints = $parameterBag->get(name: 'crypto_endpoints');
    }

    public function getBitcoinExchangeRate(): BitcoinDto
    {
        try {
            $responseArray = $this->httpClient->request(method: 'GET', url: $this->endpoints['bitcoin']['url'])->toArray();
            return BitcoinDtoFactory::createBitcoinDto(response: $responseArray);
        } catch (\Exception $exception) {
           $this->logger->error(message: $exception->getMessage());
            throw $exception;
        }
    }
}