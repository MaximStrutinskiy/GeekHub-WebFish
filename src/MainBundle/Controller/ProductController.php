<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller {

  public function ProductAction() {

      $em = $this->getDoctrine()->getManager();
      $postRepository = $em->getRepository('MainBundle:Product');
      $query = $postRepository->findProductsQuery();
      $breadcrumbs = $this
          ->get('white_october_breadcrumbs')
          ->addItem('Home', $this->get('router')->generate('home'))
          ->addItem('Shop');
      $pagination = $this->get('knp_paginator');
      $request = $this->get('request_stack')->getMasterRequest();
      $result = $pagination->paginate(
          $query,
          $request->query->getInt('page', 1),
          20
      );

      return $this->render(
          'MainBundle:Page:_product.html.twig',
          [
              'product' => $result,
          ]
      );
  }
}
