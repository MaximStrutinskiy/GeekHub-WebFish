<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller {

  public function ProductAction() {

    return $this->render(
      'MainBundle:Page:_product.html.twig'
    );
  }
}
