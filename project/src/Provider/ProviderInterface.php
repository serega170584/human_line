<?php

declare(strict_types=1);

namespace App\Provider;

interface ProviderInterface
{
    public function getResponse(): array;
}
