<?php

declare(strict_types=1);

namespace App\Provider;

class QuickDeliveryTestProvider implements ProviderInterface
{
    /**
     * @throws \Exception
     */
    public function getOffer(): array
    {
        return [
            'price' => rand(3, 10) * 0.5,
            'period' => mt_rand(3, 10),
        ];
    }

    /**
     * @throws \Exception
     */
    public function addOrder(): array
    {
        return [
            'price' => rand(3, 10) * 0.5,
            'period' => mt_rand(3, 10),
        ];
    }
}
