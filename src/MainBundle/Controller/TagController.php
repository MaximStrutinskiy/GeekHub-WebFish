<?php
namespace MainBundle\Controller;

use MainBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TagController extends Controller {

  public function showTagAction() {
    $em = $this->getDoctrine();
    $tagRepository = $em->getRepository("MainBundle:Tag");
    $getAllTag = $tagRepository->findAll();

    return $this->render(
      'MainBundle:Component:_tag.html.twig',
      [
        'tags' => $getAllTag,
      ]
    );
  }

  public function showInternalTagAction($id) {
    $em = $this->getDoctrine();
    $tagRepository = $em->getRepository("MainBundle:Tag");
    $tagId = array("id" => $id);
    $tagName = $tagRepository->findOneBy($tagId);
    $allTags = $tagRepository->findAll();

    $postRepository = $this->getDoctrine()->getRepository('MainBundle:Post');
    $query = $postRepository->findAllPostByTagQuery($tagName);

    $breadcrumbs = $this
      ->get('white_october_breadcrumbs')
      ->addItem("Home", $this->get("router")->generate("home"))
      ->addItem("Blog", $this->get("router")->generate("blog"))
      ->addItem("Tag")
      ->addItem($tagName->getName());

    $pagination = $this->get('knp_paginator');
    $request = $this->get('request_stack')->getMasterRequest();
    $result = $pagination->paginate(
      $query,
      $request->query->getInt('page', 1),
      5
    );

    return $this->render(
      "MainBundle:Page:_tag_internal.html.twig",
      [
        'setTags' => $allTags,
        'tag' => $tagName,
        'posts' => $result,
      ]
    );
  }
}
