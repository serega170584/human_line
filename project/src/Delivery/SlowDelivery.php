<?php

declare(strict_types=1);

namespace App\Delivery;

use App\Provider\ProviderInterface;

class SlowDelivery implements DeliveryInterface
{
    private const BASE_PRICE = 15000;

    public function __construct(
        public readonly ProviderInterface $provider
    )
    {
    }

    public function getRows(): array
    {
        $price = null;
        $date = null;

        $response = $this->provider->getResponse();

        $error = $response['error'] ?? null;

        if (null === $error) {
            $coefficient = $response['coefficient'];
            $date = $response['date'];

            $money = \Money\Money::RUB(self::BASE_PRICE);
            $money->multiply($coefficient);
            $price = $money->getAmount() / 100;
        }

        return [
            'price' => $price,
            'date' => $date,
            'error' => $error
        ];
    }
}
