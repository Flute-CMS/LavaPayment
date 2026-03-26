<?php

namespace Omnipay\Lava;

use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    public function getName(): string
    {
        return 'Lava';
    }

    public function getDefaultParameters(): array
    {
        return [
            'shopId' => '',
            'secretKey' => '',
            'additionalKey' => '',
        ];
    }

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

    public function purchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Lava\Message\PurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Lava\Message\CompletePurchaseRequest', $parameters);
    }
}
