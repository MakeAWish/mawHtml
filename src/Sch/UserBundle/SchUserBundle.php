<?php

namespace Sch\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SchUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
