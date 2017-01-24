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
class ProfileController extends BaseController {

  /**
   * Edit the user.
   *
   * @param Request $request
   *
   * @return Response
   */
  public function editAction(Request $request) {
    $user = $this->getUser();
    if (!is_object($user) || !$user instanceof UserInterface) {
      throw new AccessDeniedException('This user does not have access to this section.');
    }
    /** @var $dispatcher EventDispatcherInterface */
    $dispatcher = $this->get('event_dispatcher');
    $event = new GetResponseUserEvent($user, $request);
    $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);
    if (NULL !== $event->getResponse()) {
      return $event->getResponse();
    }
    /** @var $formFactory FactoryInterface */
    $formFactory = $this->get('fos_user.profile.form.factory');
    $form = $formFactory->createForm();
    $form->setData($user);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {

//      no mapped
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

//      mapped
//      $img = $this->getForm()->get('img')->getData(); // Mapped false.
//      if ($img !== NULL) {
//        $fileName = md5(uniqid()) . '.' . $img->getExtension();
//        $img->move(
//          $this->getConfigurationPool()
//            ->getContainer()
//            ->getParameter('user_images'),
//          $fileName
//        );
//        $img->setImg($fileName);
//      }

      /** @var $userManager UserManagerInterface */
      $userManager = $this->get('fos_user.user_manager');
      $event = new FormEvent($form, $request);
      $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);
      $userManager->updateUser($user);
      if (NULL === $response = $event->getResponse()) {
        $url = $this->generateUrl('fos_user_profile_show');
        $response = new RedirectResponse($url);
      }
      $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));
      return $response;
    }
    return $this->render('FOSUserBundle:Profile:edit.html.twig', array(
      'form' => $form->createView(),
    ));
  }
}
