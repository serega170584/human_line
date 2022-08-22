<?php

declare(strict_types=1);

namespace App\Provider;

class QuickDeliveryTestProvider implements ProviderInterface
{
    /**
     * @throws \Exception
     */
    public function getResponse(): array
    {
        $date = new \DateTime('now', new \DateTimeZone('UTC'));
        $days = mt_rand(3, 10);
        $interval = \DateInterval::createFromDateString("+{$days} day");
        $date->add($interval);
        return [
            'price' => rand(3, 10) * 0.5,
            'date' => $date->format('Y-m-d'),
        ];
    }
}
