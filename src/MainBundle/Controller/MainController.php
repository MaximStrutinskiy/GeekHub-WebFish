<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class MainController
 *
 * @package MainBundle\Controller
 */
class MainController extends Controller {

  /**
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function indexAction() {
    return $this->render('MainBundle::base.html.twig');
  }

  /**
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function blogAction() {
    //add breadcrumbs
    $breadcrumbs = $this
      ->get('white_october_breadcrumbs')
      ->addItem('Home', $this->get('router')->generate('home'))
      ->addItem('Blog');

    return $this->render('MainBundle:Page:_blog.html.twig');
  }
}
