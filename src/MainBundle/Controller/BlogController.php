<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Comment;
use MainBundle\Entity\Like;
use MainBundle\Entity\Post;
use MainBundle\Forms\FormCommentType;
use MainBundle\Forms\FormLikeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller {

  public function blogAction() {
    $em = $this->getDoctrine();
    $postRepository = $em->getRepository('MainBundle:Post');
    $query = $postRepository->findPostsQuery();
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

    // Comment
    $comment = new Comment();
    if ($this->getUser() !== NULL && $post !== NULL) {
      $comment
        ->setPost($post)
        ->addUser($this->getUser());
    }

    $commentForm = $this->createForm(FormCommentType::class, $comment);
    $commentForm->handleRequest($request);
    if ($commentForm->isSubmitted() && $commentForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($comment);
      $em->flush();

      return $this->redirectToRoute(
        'blog-post',
        array(
          'id' => $post->getId(),
          'shortTitle' => $post->getShortTitle(),
        )
      );
    }

    return $this->render(
      "MainBundle:Page:_internal_blog.html.twig",
      [
        'post' => $post,
        'form_comment' => $commentForm->createView(),
        'show_comment' => $commentPost,
      ]
    );
  }

  public function blogLikeAction($post_id, Request $request) {
    $em = $this->getDoctrine();
    $likeRepository = $em->getRepository("MainBundle:Like");
    $postRepository = $em->getRepository("MainBundle:Post");

    $countPostLikes = $likeRepository->getCountPostLikesIDResult($post_id);
    $likeCheck = $likeRepository->checkUserPostLikeResult($post_id, $this->getUser());
    $post = $postRepository->find($post_id);

    $request = $this->get('request_stack')->getMasterRequest();
    if ($likeCheck == null) {
      $statusLike = 0;
      $like = new Like();

      if ($this->getUser() !== null && $post_id !== null && $post !== null) {
        $like
          ->setPost($post)
          ->setUser($this->getUser());
      }
      $likeForm = $this->createForm(FormLikeType::class, $like);
      $likeForm->handleRequest($request);
      if ($likeForm->isSubmitted()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($like);
        $em->flush();

//        return $this->forward($request->getUri());
      }
    }
    else {
      $statusLike = 1;
      $likeForm = $this->createForm(FormLikeType::class);
      $likeForm->handleRequest($request);
      if ($likeForm->isSubmitted()) {
        $em = $this->getDoctrine()->getManager();
        foreach ($likeCheck as $likeChecks) {
          $em->remove($likeChecks);
        }
        $em->flush();

//        return $this->forward($request->getUri());
      }
    }

    return $this->render(
      "MainBundle:Component:_like.html.twig",
      [
        'post_id' => $post_id,
        'form_like' => $likeForm->createView(),
        'show_count_like' => $countPostLikes,
        'show_status_like' => $statusLike,
      ]
    );
  }
}
