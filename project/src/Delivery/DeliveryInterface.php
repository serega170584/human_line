<?php

declare(strict_types=1);

namespace App\Delivery;

interface DeliveryInterface
{
    public function getRows(): array;
}
