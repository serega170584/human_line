<?php

declare(strict_types=1);

namespace App\Delivery;

use App\Provider\ProviderInterface;

class QuickDelivery implements DeliveryInterface
{
    public function __construct(
        public readonly ProviderInterface $provider
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function getRows(): array
    {
        $price = null;
        $date = null;

        $deadLine = new \DateTime('now', new \DateTimeZone('UTC'));
        $deadLine->setTime(15, 0, 0);

        $currentDateTime = new \DateTime('now', new \DateTimeZone('UTC'));

        $response = $this->provider->getResponse();

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
}
