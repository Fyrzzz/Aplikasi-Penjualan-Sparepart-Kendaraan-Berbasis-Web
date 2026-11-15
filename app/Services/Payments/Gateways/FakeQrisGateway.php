<?php

namespace App\Services\Payments\Gateways;

use App\Services\Payments\Contracts\PaymentGateway;
use App\Services\Payments\Data\PaymentChargeRequest;
use App\Services\Payments\Data\QrisCharge;
use App\Services\Payments\Exceptions\GatewayUnavailableException;
use InvalidArgumentException;

final class FakeQrisGateway implements PaymentGateway
{
    public function createQrisCharge(PaymentChargeRequest $request): QrisCharge
    {
        if (config('services.qris.fake_unavailable')) {
            throw new GatewayUnavailableException('Sandbox QRIS is configured as unavailable.');
        }

        if ($request->amount < 1) {
            throw new InvalidArgumentException('QRIS amount must be a positive number of Rupiah.');
        }

        $merchantAccount = $this->field('00', 'ID.CO.AMAHAY.SANDBOX')
            .$this->field('01', (string) config('services.qris.merchant_id'));
        $additionalData = $this->field('05', substr($request->paymentReference, 0, 25));
        $payload = $this->field('00', '01')
            .$this->field('01', '12')
            .$this->field('26', $merchantAccount)
            .$this->field('52', '0000')
            .$this->field('53', '360')
            .$this->field('54', (string) $request->amount)
            .$this->field('58', 'ID')
            .$this->field('59', (string) config('services.qris.merchant_name'))
            .$this->field('60', (string) config('services.qris.merchant_city'))
            .$this->field('62', $additionalData)
            .'6304';
        $payload .= strtoupper(str_pad(dechex($this->crc16($payload)), 4, '0', STR_PAD_LEFT));

        return new QrisCharge(
            paymentReference: $request->paymentReference,
            providerReference: 'SBX-'.strtoupper(substr(hash('sha256', $request->idempotencyKey), 0, 20)),
            amount: $request->amount,
            payload: $payload,
            expiresAt: $request->expiresAt,
        );
    }

    private function field(string $tag, string $value): string
    {
        $length = strlen($value);
        if ($length > 99) {
            throw new InvalidArgumentException('QRIS payload field is too long.');
        }

        return $tag.str_pad((string) $length, 2, '0', STR_PAD_LEFT).$value;
    }

    private function crc16(string $payload): int
    {
        $crc = 0xFFFF;
        foreach (str_split($payload) as $character) {
            $crc ^= ord($character) << 8;
            for ($bit = 0; $bit < 8; $bit++) {
                $crc = ($crc & 0x8000) !== 0
                    ? ($crc << 1) ^ 0x1021
                    : $crc << 1;
                $crc &= 0xFFFF;
            }
        }

        return $crc;
    }
}
