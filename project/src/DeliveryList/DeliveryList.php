<?php

declare(strict_types=1);

namespace App\DeliveryList;

use App\Delivery\DeliveryInterface;

class DeliveryList implements DeliveryListInterface
{
    private $list = [];

    public function add(DeliveryInterface $delivery): void
    {
        $this->list[] = $delivery;
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        return $this->list;
    }
}
