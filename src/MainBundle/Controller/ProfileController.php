<?php

namespace MainBundle\Controller;

use FOS\UserBundle\Controller\ProfileController as BaseController;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class ProfileController
 *
 * @package MainBundle\Controller
 */
class ProfileController extends BaseController
{
    /**
     * Show the user.
     */
    public function showAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        //add breadcrumbs
        $breadcrumbs = $this
            ->get('white_october_breadcrumbs')
            ->addItem('Home', $this->get('router')->generate('home'))
            ->addItem('Profile');

        return $this->render('@FOSUser/Profile/show.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * Edit the user.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');
        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);
        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }
        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.profile.form.factory');
        $form = $formFactory->createForm();
        $form->setData($user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $img = $form->get('img')->getData();
            if ($img !== null) {

                $fileName = md5(uniqid()).'.'.$img->getExtension();

                $img->move(
                    $this->getParameter('user_images'),
                    $fileName
                );

                $user->setImg($fileName);
            }

            /** @var $userManager UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);
            $userManager->updateUser($user);
            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_profile_show');
                $response = new RedirectResponse($url);
            }
            $dispatcher->dispatch(
                FOSUserEvents::PROFILE_EDIT_COMPLETED,
                new FilterUserResponseEvent($user, $request, $response)
            );

            return $response;
        }

        //add breadcrumbs
        $breadcrumbs = $this
            ->get('white_october_breadcrumbs')
            ->addItem('Home', $this->get('router')->generate('home'))
            ->addItem('Profile', $this->get('router')->generate('fos_user_profile_show'))
            ->addItem('Edit profile');

        return $this->render(
            'FOSUserBundle:Profile:edit.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }
}
