<?php
/**
 * Created by PhpStorm.
 * User: alpha
 * Date: 02.02.17
 * Time: 17:39
 */

namespace MainBundle\Controller;

use MainBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoryController extends Controller
{

    public function showCategoryAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $postRepository = $em->getRepository("MainBundle:Post");
        $result = $postRepository->findCountPostsWithCategoryResult();

        return $this->render(
            "MainBundle:Component:_category.html.twig",
            [
                "categories" => $result,
            ]
        );
    }

    public function showInternalCategoryAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categoryRepository = $em->getRepository("MainBundle:Category");
        $postRepository = $em->getRepository('MainBundle:Post');

        $categoryId = array("id" => $id,);
        $categoryName = $categoryRepository->findOneBy($categoryId);

        $query = $postRepository->findAllPostByCategoryQuery($id);

        $breadcrumbs = $this
            ->get('white_october_breadcrumbs')
            ->addItem("Home", $this->get("router")->generate("home"))
            ->addItem("Blog", $this->get("router")->generate("blog"))
            ->addItem("Category")
            ->addItem($categoryName->getName());

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
                'category' => $categoryName,
                'posts' => $result,
            ]
        );
    }
}
