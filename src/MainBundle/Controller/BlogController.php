<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Comment;
use MainBundle\Entity\Like;
use MainBundle\Entity\Post;
use MainBundle\Forms\FormCommentType;
use MainBundle\Forms\FormLikeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function blogAction()
    {
        $em = $this->getDoctrine();
        $postRepository = $em->getRepository('MainBundle:Post');
        $query = $postRepository->findAllPostsQuery();
        $post = $postRepository->findAllPostsQuery()->getResult();

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

        // Like
        $em = $this->getDoctrine();
        $likeRepository = $em->getRepository("MainBundle:Like");

        $countPostLikes = $likeRepository->getCountPostLikesID($post);
        $likeCheck = $likeRepository->checkUserPostLike($post, $this->getUser());

        if ($likeCheck == null) {
            $statusLike = 0;
            $like = new Like();
            if ($this->getUser() !== null && $post !== null) {
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

                // Add ajax
                return $this->redirectToRoute(
                    'blog-post',
                    array(
                        'id' => $post->getId(),
                        'shortTitle' => $post->getShortTitle(),
                    )
                );
            }
        } else {
            $statusLike = 1;
            $likeForm = $this->createForm(FormLikeType::class);
            $likeForm->handleRequest($request);
            if ($likeForm->isSubmitted()) {
                $em = $this->getDoctrine()->getManager();
                foreach ($likeCheck as $likeChecks) {
                    $em->remove($likeChecks);
                }
                $em->flush();

                // Add ajax
                return $this->redirectToRoute(
                    'blog-post',
                    array(
                        'id' => $post->getId(),
                        'shortTitle' => $post->getShortTitle(),
                    )
                );
            }
            // remove likes from posts
        }

        // Like

        return $this->render(
            'MainBundle:Page:_blog.html.twig',
            [
                'posts' => $result,
                'form_like' => $likeForm->createView(),
                'show_count_like' => $countPostLikes,
                'show_status_like' => $statusLike,
            ]
        );
    }

    /**
     * show internal post
     */
    public function blogInternalAction($id, Request $request, Post $post)
    {
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
        if ($this->getUser() !== null && $post !== null) {
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
        // Comment

        // Like
        $em = $this->getDoctrine();
        $likeRepository = $em->getRepository("MainBundle:Like");

        $countPostLikes = $likeRepository->getCountPostLikesID($post);
        $likeCheck = $likeRepository->checkUserPostLike($post, $this->getUser());

        if ($likeCheck == null) {
            $statusLike = 0;
            $like = new Like();
            if ($this->getUser() !== null && $post !== null) {
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

                // Add ajax
                return $this->redirectToRoute(
                    'blog-post',
                    array(
                        'id' => $post->getId(),
                        'shortTitle' => $post->getShortTitle(),
                    )
                );
            }
        } else {
            $statusLike = 1;
            $likeForm = $this->createForm(FormLikeType::class);
            $likeForm->handleRequest($request);
            if ($likeForm->isSubmitted()) {
                $em = $this->getDoctrine()->getManager();
                foreach ($likeCheck as $likeChecks) {
                    $em->remove($likeChecks);
                }
                $em->flush();

                // Add ajax
                return $this->redirectToRoute(
                    'blog-post',
                    array(
                        'id' => $post->getId(),
                        'shortTitle' => $post->getShortTitle(),
                    )
                );
            }
            // remove likes from posts
        }

        // Like

        return $this->render(
            "MainBundle:Page:_internal_blog.html.twig",
            [
                'post' => $post,
                'form_comment' => $commentForm->createView(),
                'form_like' => $likeForm->createView(),
                'show_comment' => $commentPost,
                'show_count_like' => $countPostLikes,
                'show_status_like' => $statusLike,
            ]
        );
    }
}
