<?php
namespace MainBundle\Controller;

use MainBundle\Forms\FormSearchComponentType;
use MainBundle\Forms\FormSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{

    public function indexAction(Request $request)
    {
        $breadcrumbs = $this
            ->get('white_october_breadcrumbs')
            ->addItem('Home', $this->get('router')->generate('home'))
            ->addItem('Search');

        $em = $this->getDoctrine()->getManager();
        $postRepository = $em->getRepository("MainBundle:Post");

        $form = $this->createForm(FormSearchType::class);
        $form->handleRequest($request);

        $post_query = $postRepository->findPostsQuery();

        if ($form->isSubmitted() && $form->isValid()) {
            $search_text = $form->get('searchText')->getData();

            if ($search_text !== null) {
                $post_query = $postRepository->findPostByTitle($search_text);
            }
        }

        $pagination = $this->get('knp_paginator');
        $request = $this->get('request_stack')->getMasterRequest();
        $posts = $pagination->paginate(
            $post_query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render(
            'MainBundle:Page:_search.html.twig',
            [
                'search_form' => $form->createView(),
                'posts' => $posts,
            ]
        );
    }

    public function componentAction(Request $request)
    {
        $form = $this->createForm(FormSearchComponentType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $queryText = $form->getData();

            return $this->redirect(
                $this->generateUrl(
                    'search',
                    [
                        'query' => $queryText,
                    ]
                )
            );
        }

        return $this->render(
            'MainBundle:Component:_search.component.html.twig',
            [
                'search_form' => $form->createView(),
            ]
        );
    }
}