<?php

namespace Omnipay\Lava\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    public function isSuccessful(): bool
    {
        return false;
    }

    public function isRedirect(): bool
    {
        return !empty($this->getRedirectUrl()) && ($this->data['status'] ?? 0) === 200;
    }

    public function getRedirectUrl(): ?string
    {
        return $this->data['data']['url'] ?? null;
    }

    public function getRedirectMethod(): string
    {
        return 'GET';
    }

    public function getRedirectData(): array
    {
        return [];
    }

    public function getMessage(): ?string
    {
        return $this->data['error'] ?? $this->data['message'] ?? null;
    }

    public function getCode(): ?string
    {
        return isset($this->data['status']) ? (string) $this->data['status'] : null;
    }

    public function getTransactionReference(): ?string
    {
        return $this->data['data']['id'] ?? null;
    }
}
