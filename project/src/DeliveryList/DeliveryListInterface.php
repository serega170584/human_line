<?php

declare(strict_types=1);

namespace App\DeliveryList;

use App\Delivery\DeliveryInterface;

interface DeliveryListInterface
{
    public function add(DeliveryInterface $delivery): void;
}
