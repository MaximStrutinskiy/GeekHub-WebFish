<?php

namespace MainBundle\Controller;

use MainBundle\Entity\User;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RegistrationController
 *
 * @package MainBundle\Controller
 */
class RegistrationController extends BaseController {
  public function registerAction(Request $request) {
    $user = new User();
    $dispatcher = $this->get('event_dispatcher');
    $formFactory = $this->get('fos_user.registration.form.factory');
    $userManager = $this->get('fos_user.user_manager');

    $user->setEnabled(TRUE);

    $event = new GetResponseUserEvent($user, $request);
    $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

    if (NULL !== $event->getResponse()) {
      return $event->getResponse();
    }

    $form = $formFactory->createForm();
    $form->setData($user);

    $form->handleRequest($request);

    if ($form->isSubmitted()) {
      if ($form->isValid()) {

        $img = $user->getImg();
        if ($img !== NULL) {
          $img = $user->getImg();
          // Generate a unique name for the file before saving it
          $fileName = md5(uniqid()) . '.' . $img->getExtension();

          // Move the file to the directory where brochures are stored
          $img->move(
            $this->getParameter('user_images'),
            $fileName
          );
          // Update the 'img' property to store the img file name
          // instead of its contents
          $user->setImg($fileName);
        }

        $event = new FormEvent($form, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

        $userManager->updateUser($user);

        if (NULL === $response = $event->getResponse()) {
          $url = $this->generateUrl('fos_user_registration_confirmed');
          $response = new RedirectResponse($url);
        }

        $dispatcher->dispatch(
          FOSUserEvents::REGISTRATION_COMPLETED,
          new FilterUserResponseEvent($user, $request, $response)
        );

        return $response;
      }

      $event = new FormEvent($form, $request);
      $dispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

      if (NULL !== $response = $event->getResponse()) {
        return $response;
      }
    }

    return $this->render(
      'FOSUserBundle:Registration:register.html.twig',
      [
        'form' => $form->createView(),
      ]
    );
  }
}
