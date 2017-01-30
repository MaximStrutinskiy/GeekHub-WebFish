<?php

namespace MainBundle\Controller;

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
    public function blogInternalAction($id)
    {
        $em = $this->getDoctrine();
        $postRepository = $em->getRepository("MainBundle:Post");
        $post = $postRepository->find($id);

        //add breadcrumbs
        $breadcrumbs = $this->get('white_october_breadcrumbs');
        $breadcrumbs->addItem("Home", $this->get("router")->generate("home"));
        $breadcrumbs->addItem("Blog", $this->get("router")->generate("blog"));
        $breadcrumbs->addItem($post->getShortTitle());

        return $this->render(
            "MainBundle:Page:_internal_blog.html.twig",
            [
                'post' => $post,
            ]
        );
    }


    /**
     * =====CATEGORY======
     */
    /**
     * show all category's
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

    /**
     * show all post with category $id
     * @param int $id
     */
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
}
