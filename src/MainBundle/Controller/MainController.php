<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Comment;
use MainBundle\Entity\Post;
use MainBundle\Forms\FormCommentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class MainController
 *
 * @package MainBundle\Controller
 */
class MainController extends Controller
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('MainBundle::base.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function blogAction()
    {
        $postRepository = $this->getDoctrine()->getRepository('MainBundle:Post');
        $query = $postRepository->findAllPostsQuery();

        //add breadcrumbs
        $breadcrumbs = $this
            ->get('white_october_breadcrumbs')
            ->addItem('Home', $this->get('router')->generate('home'))
            ->addItem('Blog');

        //pagination
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
    public function blogInternalAction($id, Request $request, Post $post)
    {
        $em = $this->getDoctrine();
        $postRepository = $em->getRepository("MainBundle:Post");
        $post = $postRepository->find($id);

        $commentRepository = $em->getRepository("MainBundle:Comment");
        $commentPost = $commentRepository->findAllComments($id);

        //add breadcrumbs
        $breadcrumbs = $this->get('white_october_breadcrumbs');
        $breadcrumbs->addItem("Home", $this->get("router")->generate("home"));
        $breadcrumbs->addItem("Blog", $this->get("router")->generate("blog"));
        $breadcrumbs->addItem($post->getShortTitle());

        //add comments for post
        // task - check user info
        $comment = new Comment();
        $comment
            ->setPost($post)
            ->addUser($this->getUser());

        $form = $this->createForm(FormCommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute(
                'blog-post',
                array('id' => $post->getId(), 'shortTitle' => $post->getShortTitle())
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

    /**
     * =====CATEGORY======
     */

    public function showCategoryAction()
    {
        $em = $this->getDoctrine();
        $categoryRepository = $em->getRepository("MainBundle:Category");
        $categories = $categoryRepository->findAll();

        return $this->render(
            'MainBundle:Component:_category.html.twig',
            [
                'categories' => $categories,
            ]
        );
    }

    public function showInternalCategoryAction($id, Request $request)
    {
        $em = $this->getDoctrine();
        $categoryRepository = $em->getRepository("MainBundle:Category");
        $findCategoryName = array("id" => $id,);
        $oneCategory = $categoryRepository->findOneBy($findCategoryName);
        $postRepository = $this->getDoctrine()->getRepository('MainBundle:Post');
        $query = $postRepository->findAllPostByCategoryQuery($id);

        //breadcrumbs
        $breadcrumbs = $this->get('white_october_breadcrumbs');
        $breadcrumbs->addItem("Home", $this->get("router")->generate("home"));
        $breadcrumbs->addItem("Blog", $this->get("router")->generate("blog"));
        $breadcrumbs->addItem("Category");
        $breadcrumbs->addItem($oneCategory->getName());

        //pagination
        $pagination = $this->get('knp_paginator');
        $request = $this->get('request_stack')->getMasterRequest();
        $result = $pagination->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render(
            "MainBundle:Page:_category_internal.html.twig",
            [
                'category' => $oneCategory,
                'posts' => $result,
            ]
        );
    }


    public function showCountCategoryAction($id, Request $request)
    {
        $categoryRepository = $this->getDoctrine()->getRepository('MainBundle:Post');
        $result = $categoryRepository->findCountPostsWithCategory($id);

        return $this->render(
            'MainBundle:Component:_count_category.html.twig',
            [
                'count_categories' => $result,
            ]
        );
    }

    /**
     * =======TAG========
     */

    public function showTagAction()
    {
        $em = $this->getDoctrine();
        $tagRepository = $em->getRepository("MainBundle:Tag");
        $allTag = $tagRepository->findAll();

        return $this->render(
            'MainBundle:Component:_tag.html.twig',
            [
                'tags' => $allTag,
            ]
        );
    }

    public function showInternalTagAction($id)
    {
        $em = $this->getDoctrine();
        $tagRepository = $em->getRepository("MainBundle:Tag");
        $findTagName = array("id" => $id);
        $tagName = $tagRepository->findOneBy($findTagName);
        $allTags = $tagRepository->findAll();
        $postRepository = $this->getDoctrine()->getRepository('MainBundle:Post');
        $query = $postRepository->findAllPostByTagQuery($tagName);

        //breadcrumbs
        $breadcrumbs = $this->get('white_october_breadcrumbs');
        $breadcrumbs->addItem("Home", $this->get("router")->generate("home"));
        $breadcrumbs->addItem("Blog", $this->get("router")->generate("blog"));
        $breadcrumbs->addItem("Tag");
        $breadcrumbs->addItem($tagName->getName());

        //pagination
        $paginator = $this->get('knp_paginator');
        $request = $this->get('request_stack')->getMasterRequest();
        $result = $paginator->paginate(
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
