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

    public function blogAction()
    {
        $em = $this->getDoctrine()->getManager();
        $postRepository = $em->getRepository('MainBundle:Post');
        $query = $postRepository->findPostsWithCountCommentQuery();
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

    public function blogInternalAction( Request $request, Post $post, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $postRepository = $em->getRepository("MainBundle:Post");
        $post = $postRepository->find($id);
        $postCountComment = $postRepository->findCountPostsWithCommentResult($id);

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

        return $this->render(
            "MainBundle:Page:_internal_blog.html.twig",
            [
                'post' => $post,
                'form_comment' => $commentForm->createView(),
                'show_comment' => $commentPost,
                'postCountComment' => $postCountComment->getResult(),
            ]
        );
    }

    public function blogLikeAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $likeRepository = $em->getRepository("MainBundle:Like");
        $postRepository = $em->getRepository("MainBundle:Post");
        $post = $postRepository->find($id);

        if (!$post) {
            throw $this->createNotFoundException();
        }

        if (($user = $this->getUser()) === null) {

            return $this->render(
              "MainBundle:Component:_like.html.twig",
              [
                'like_count' => $likeRepository->getCountByPost($post),
              ]
            );
        }

        $like = $likeRepository->findOneBy(
            [
                'post' => $post,
                'user' => $user,
            ]
        );
        $likeForm = $this->get('form.factory')->createNamed(
            'blog_post_like_'.$id,
            FormLikeType::class,
            null,
            [
                'action' => $this->generateUrl(
                    'blog-post-like',
                    [
                        'id' => $id,
                    ]
                ),
            ]
        );
        $likeForm->handleRequest($request);

        if ($likeForm->isSubmitted() && $likeForm->isValid()) {
            if ($like == null) {
                $like = new Like();
                $like
                    ->setPost($post)
                    ->setUser($this->getUser());
                $em->persist($like);
            } else {
                $em->remove($like);
            }

            $em->flush();

            return $this->redirect(
                $request->headers->has('referer')
                    ? $request->headers->get('referer')
                    : $this->generateUrl('blog')
            );
        }

        return $this->render(
            "MainBundle:Component:_like.html.twig",
            [
                'post_id' => $id,
                'form_like' => $likeForm->createView(),
                'like_count' => $likeRepository->getCountByPost($post),
                'show_status_like' => $like === null,
            ]
        );
    }
}
