<?php

declare(strict_types=1);

namespace App\Delivery;

use App\Provider\ProviderInterface;

class SlowDelivery implements DeliveryInterface
{
    private const BASE_PRICE = 150;

    private string $sourceKladr;
    private string $targetKladr;
    private float $weight;

    public function __construct(
        public readonly ProviderInterface $provider,
        public readonly string $uuid
    )
    {
    }

    public function getOffer(): array
    {
        $price = null;
        $date = null;

        $response = $this->provider->getResponse();

        $error = $response['error'] ?? null;

        if (null === $error) {
            $coefficient = $response['coefficient'];
            $date = $response['date'];

            $money = \Money\Money::RUB(self::BASE_PRICE);
            $money = $money->multiply($coefficient);

            $price = $money->getAmount();
        }

        return [
            'price' => $price,
            'date' => $date,
            'error' => $error
        ];
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }
    /**
     * @param string $sourceKladr
     */
    public function setSourceKladr(string $sourceKladr): void
    {
        $this->sourceKladr = $sourceKladr;
    }

    /**
     * @param string $targetKladr
     */
    public function setTargetKladr(string $targetKladr): void
    {
        $this->targetKladr = $targetKladr;
    }

    /**
     * @param float $weight
     */
    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return string
     */
    public function getSourceKladr(): string
    {
        return $this->sourceKladr;
    }

    /**
     * @return string
     */
    public function getTargetKladr(): string
    {
        return $this->targetKladr;
    }

    /**
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }
}

