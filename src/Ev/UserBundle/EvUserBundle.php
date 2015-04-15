<?php

namespace Ev\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class EvUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}