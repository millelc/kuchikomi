<?php

namespace obdo\KuchiKomiUserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class obdoKuchiKomiUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
