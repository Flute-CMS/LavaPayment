<?php

namespace Flute\Modules\LavaPayment\Providers;

use Flute\Core\Modules\Payments\Events\RegisterPaymentFactoriesEvent;
use Flute\Core\Modules\Payments\Factories\PaymentDriverFactory;
use Flute\Core\Support\ModuleServiceProvider;
use Flute\Modules\LavaPayment\Listeners\LavaRegisterListener;
use Flute\Modules\LavaPayment\Omnipay\LavaDriver;

class LavaPaymentProvider extends ModuleServiceProvider
{
    public function boot(\DI\Container $container): void
    {
        $this->bootstrapModule();

        $this->loadViews('Resources/views', 'flute-lava');

        app(PaymentDriverFactory::class)->register('Lava', LavaDriver::class);

        events()->addDeferredListener(RegisterPaymentFactoriesEvent::NAME, [
            LavaRegisterListener::class,
            'registerLava',
        ]);
    }

    public function register(\DI\Container $container): void
    {
    }
}
