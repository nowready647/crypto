<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\CryptoApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CryptoController extends AbstractController
{
    public function __construct(
        private readonly CryptoApiService $cryptoApiService,
    ) {}

    public function getExchangeRate(): Response
    {
        return $this->render(view: 'crypto/bitcoin.html.twig');
    }

    public function getBitcoinExchangeRate(): JsonResponse
    {
        $responseDto = $this->cryptoApiService->getBitcoinExchangeRate();

        return new JsonResponse(
            data:
            [
                'updated' => $responseDto->getUpdated()->format('d.m.Y H:i'),
                'usd' => $responseDto->getUsdRate(),
                'eur' => $responseDto->getEurRate(),
            ]
        );
    }
}