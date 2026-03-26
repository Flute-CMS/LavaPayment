<?php

namespace Omnipay\Lava\Message;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class CompletePurchaseResponse extends AbstractResponse
{
    protected $request;

    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        $this->data = $data;

        if (empty($this->data['invoice_id']) || empty($this->data['order_id'])) {
            throw new InvalidResponseException('Missing required fields in webhook');
        }

        $sign = $this->data['sign'] ?? null;
        $additionalKey = $this->request->getAdditionalKey();

        if (!empty($additionalKey)) {
            if (empty($sign)) {
                throw new InvalidResponseException('Missing signature in webhook');
            }

            $expectedSign = $this->calculateSign();

            if (!hash_equals($expectedSign, $sign)) {
                throw new InvalidResponseException('Invalid webhook signature');
            }
        }
    }

    public function isSuccessful(): bool
    {
        return ($this->data['status'] ?? '') === 'success';
    }

    public function getTransactionId(): ?string
    {
        return $this->data['order_id'] ?? null;
    }

    public function getTransactionReference(): ?string
    {
        return $this->data['invoice_id'] ?? null;
    }

    public function getAmount(): ?string
    {
        if (!isset($this->data['amount'])) {
            return null;
        }

        return number_format((float) $this->data['amount'], 2, '.', '');
    }

    public function getStatus(): ?string
    {
        return $this->data['status'] ?? null;
    }

    public function getMessage(): ?string
    {
        return $this->data['status'] ?? null;
    }

    public function getCode(): ?string
    {
        return null;
    }

    /**
     * Calculate expected webhook signature.
     *
     * Lava webhook sign: md5("invoice_id:amount:pay_time:secret_key_2")
     */
    protected function calculateSign(): string
    {
        return md5(implode(':', [
            $this->data['invoice_id'],
            $this->data['amount'],
            $this->data['pay_time'],
            $this->request->getAdditionalKey(),
        ]));
    }
}
