<?php

namespace App\Services\Payments\Data;

use Carbon\CarbonImmutable;

final readonly class QrisCharge
{
    public function __construct(
        public string $paymentReference,
        public string $providerReference,
        public int $amount,
        public string $payload,
        public CarbonImmutable $expiresAt,
    ) {}
}
