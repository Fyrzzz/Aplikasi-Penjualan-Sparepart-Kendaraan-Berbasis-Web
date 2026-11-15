<?php

namespace App\Services\Payments\Contracts;

use App\Services\Payments\Data\PaymentChargeRequest;
use App\Services\Payments\Data\QrisCharge;

interface PaymentGateway
{
    public function createQrisCharge(PaymentChargeRequest $request): QrisCharge;
}
