<?php
/**
 * Created by PhpStorm.
 * User: alpha
 * Date: 02.02.17
 * Time: 17:36
 */

namespace MainBundle\Controller;

use MainBundle\Entity\Comment;
use MainBundle\Entity\Post;
use MainBundle\Forms\FormCommentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller {

  /**
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function blogAction() {
    $em = $this->getDoctrine();
    $postRepository = $em->getRepository('MainBundle:Post');
    $query = $postRepository->findAllPostsQuery();

    $breadcrumbs = $this
      ->get('white_october_breadcrumbs')
      ->addItem('Home', $this->get('router')->generate('home'))
      ->addItem('Blog');

    $pagination = $this->get('knp_paginator');
    $request = $this->get('request_stack')->getMasterRequest();
    $result = $pagination->paginate(
      $query,
      $request->query->getInt('page', 1),
      5
    );

    return $this->render(
      'MainBundle:Page:_blog.html.twig',
      [
        'posts' => $result,
      ]
    );
  }

  /**
   * show internal post
   */
  public function blogInternalAction($id, Request $request, Post $post) {
    $em = $this->getDoctrine();
    $postRepository = $em->getRepository("MainBundle:Post");
    $post = $postRepository->find($id);

    $commentRepository = $em->getRepository("MainBundle:Comment");
    $commentPost = $commentRepository->findAllComments($id);

    $breadcrumbs = $this
      ->get('white_october_breadcrumbs')
      ->addItem("Home", $this->get("router")->generate("home"))
      ->addItem("Blog", $this->get("router")->generate("blog"))
      ->addItem($post->getShortTitle());

    $comment = new Comment();
    if ($this->getUser() !== NULL && $this->getUser() !== NULL) {
      $comment
        ->setPost($post)
        ->addUser($this->getUser());
    }

    $form = $this->createForm(FormCommentType::class, $comment);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($comment);
      $em->flush();

      return $this->redirectToRoute(
        'blog-post',
        array(
          'id' => $post->getId(),
          'shortTitle' => $post->getShortTitle()
        )
      );
    }

    return $this->render(
      "MainBundle:Page:_internal_blog.html.twig",
      [
        'post' => $post,
        'form_comment' => $form->createView(),
        'show_comment' => $commentPost,
      ]
    );
  }

}
