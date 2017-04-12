<?php
namespace MainBundle\Controller;

use MainBundle\Forms\FormSearchComponentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{

    public function indexAction()
    { // TODO: for /search page;
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