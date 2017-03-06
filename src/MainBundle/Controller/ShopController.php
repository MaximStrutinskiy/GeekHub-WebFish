<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Shop;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShopController extends Controller {

  // main shop page
  public function shopAction() {

    return $this->render(
      'MainBundle:Page:_shop.html.twig'
    );
  }
}
