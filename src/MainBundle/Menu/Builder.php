<?php

namespace MainBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class Builder
 *
 * @package MainBundle\Menu
 */
class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {

        $menu = $factory->createItem('root');

        // Home.
        $menu->addChild('Home', array('route' => 'home'));

        return $menu;
    }
}
