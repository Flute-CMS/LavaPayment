<?php

namespace Omnipay\Lava\Message;

class PurchaseRequest extends AbstractRequest
{
    public function getNotifyUrl(): ?string
    {
        return $this->getParameter('notifyUrl');
    }

    public function setNotifyUrl(mixed $value): self
    {
        return $this->setParameter('notifyUrl', $value);
    }

    public function getData(): array
    {
        $this->validate('shopId', 'secretKey', 'amount', 'transactionId');

        $data = [
            'sum' => (float) $this->getAmount(),
            'orderId' => $this->getTransactionId(),
            'shopId' => $this->getShopId(),
        ];

        if ($this->getReturnUrl()) {
            $data['successUrl'] = $this->getReturnUrl();
        }

        if ($this->getCancelUrl()) {
            $data['failUrl'] = $this->getCancelUrl();
        }

        if ($this->getNotifyUrl()) {
            $data['hookUrl'] = $this->getNotifyUrl();
        }

        if ($this->getDescription()) {
            $data['comment'] = mb_substr($this->getDescription(), 0, 255);
        }

        return $data;
    }

    public function sendData($data): PurchaseResponse
    {
        $signature = $this->generateSignature($data);

        $httpResponse = $this->httpClient->request(
            'POST',
            $this->baseUrl . 'create',
            [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Signature' => $signature,
            ],
            json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        );

        $responseData = json_decode($httpResponse->getBody()->getContents(), true);

        return $this->response = new PurchaseResponse($this, $responseData);
    }
}
