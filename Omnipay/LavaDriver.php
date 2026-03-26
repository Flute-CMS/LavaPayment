<?php

namespace Flute\Modules\LavaPayment\Omnipay;

use Flute\Core\Modules\Payments\Drivers\AbstractOmnipayDriver;

class LavaDriver extends AbstractOmnipayDriver
{
    public ?string $adapter = 'Lava';

    public ?string $name = 'Lava';

    public ?string $settingsView = 'flute-lava::settings';

    public function getValidationRules(): array
    {
        return [
            'settings__shopId' => ['required', 'string', 'max-str-len:255'],
            'settings__secretKey' => ['required', 'string', 'max-str-len:255'],
            'settings__additionalKey' => ['required', 'string', 'max-str-len:255'],
        ];
    }
}
