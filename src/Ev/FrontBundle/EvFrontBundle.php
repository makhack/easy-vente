<?php

namespace Ev\FrontBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class EvFrontBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
