<?php

namespace MainBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class MainBundle
 *
 * @package MainBundle
 */
class MainBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
