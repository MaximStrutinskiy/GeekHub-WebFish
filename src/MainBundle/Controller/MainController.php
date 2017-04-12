<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{

    public function indexAction()
    {
        return $this->render('MainBundle:Page:_index.html.twig');
    }
}
