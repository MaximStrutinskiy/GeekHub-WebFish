<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class MainController
 *
 * @package MainBundle\Controller
 */
class MainController extends Controller
{

  /**
   * @Route("/", name="home")
   */
    public function indexAction()
    {
        return $this->render('MainBundle::base.html.twig');
    }
}
