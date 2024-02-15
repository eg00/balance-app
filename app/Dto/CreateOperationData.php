<?php

declare(strict_types=1);

namespace App\Dto;

use Cknow\Money\Money;

class CreateOperationData
{
    public function __construct(
        public Money $value,
        public ?string $description,
    ) {
    }
}
