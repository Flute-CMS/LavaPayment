<?php

namespace Omnipay\Lava\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $zeroAmountAllowed = false;

    protected string $baseUrl = 'https://api.lava.ru/business/invoice/';

    public function getShopId(): string
    {
        return $this->getParameter('shopId') ?? '';
    }

    public function setShopId(string $value): self
    {
        return $this->setParameter('shopId', $value);
    }

    public function getSecretKey(): string
    {
        return $this->getParameter('secretKey') ?? '';
    }

    public function setSecretKey(string $value): self
    {
        return $this->setParameter('secretKey', $value);
    }

    public function getAdditionalKey(): string
    {
        return $this->getParameter('additionalKey') ?? '';
    }

    public function setAdditionalKey(string $value): self
    {
        return $this->setParameter('additionalKey', $value);
    }

    /**
     * Generate HMAC-SHA256 signature for Lava API request.
     *
     * Algorithm: ksort data, json_encode, HMAC-SHA256 with secretKey.
     */
    protected function generateSignature(array $data): string
    {
        ksort($data);

        return hash_hmac('sha256', json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), $this->getSecretKey());
    }
}
