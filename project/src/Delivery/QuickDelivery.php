<?php

declare(strict_types=1);

namespace App\Delivery;

use App\Provider\ProviderInterface;

class QuickDelivery implements DeliveryInterface
{
    private string $sourceKladr;
    private string $targetKladr;
    private float $weight;

    public function __construct(
        public readonly ProviderInterface $provider,
        public readonly string $uuid
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function getOffer(): array
    {
        $price = null;
        $date = null;

        $deadLine = new \DateTime('now', new \DateTimeZone('UTC'));
        $deadLine->setTime(15, 0, 0);

        $currentDateTime = new \DateTime('now', new \DateTimeZone('UTC'));

        $response = $this->provider->getOffer();

        if ($currentDateTime->getTimestamp() > $deadLine->getTimestamp()) {
            $error = 'Order is unavailable';
        } else {
            $error = $response['error'] ?? null;
        }

        if (null === $error) {
            $price = $response['price'];
            $period = $response['period'];
            $interval = \DateInterval::createFromDateString("{$period} day");
            $date = $currentDateTime->add($interval);
            $date = $date->format('Y-m-d');
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

    public function setSourceKladr(string $sourceKladr): void
    {
        $this->sourceKladr = $sourceKladr;
    }

    public function setTargetKladr(string $targetKladr): void
    {
        $this->targetKladr = $targetKladr;
    }

    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }

    public function getSourceKladr(): string
    {
        return $this->sourceKladr;
    }

    public function getTargetKladr(): string
    {
        return $this->targetKladr;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function addOrder(): array
    {
        return $this->provider->addOrder();
    }
}
