<?php

declare(strict_types=1);

namespace App\Provider;

class SlowDeliveryTestProvider implements ProviderInterface
{
    /**
     * @throws \Exception
     */
    public function getOffer(): array
    {
        $date = new \DateTime('now', new \DateTimeZone('UTC'));
        $days = mt_rand(3, 10);
        $interval = \DateInterval::createFromDateString("+{$days} day");
        $date->add($interval);
        return [
            'coefficient' => rand(3, 10) * 0.5,
            'date' => $date->format('Y-m-d'),
        ];
    }

    /**
     * @throws \Exception
     */
    public function addOrder(): array
    {
        $date = new \DateTime('now', new \DateTimeZone('UTC'));
        $days = mt_rand(3, 10);
        $interval = \DateInterval::createFromDateString("+{$days} day");
        $date->add($interval);
        return [
            'coefficient' => rand(3, 10) * 0.5,
            'date' => $date->format('Y-m-d'),
        ];
    }
}
