<?php

namespace Flute\Modules\LavaPayment\Listeners;

class LavaRegisterListener
{
    public static function registerLava()
    {
        app()->getLoader()->addPsr4('Omnipay\\Lava\\', module_path('LavaPayment', 'Omnipay/'));
        app()->getLoader()->register();
    }
}
