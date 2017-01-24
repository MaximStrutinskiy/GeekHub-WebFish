<?php

namespace MainBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use MainBundle\Entity\User as User;

/**
 * Class UserAdmin
 *
 * @package MainBundle\Admin
 */
class UserAdmin extends Admin {
  protected function configureFormFields(FormMapper $formMapper) {
    $formMapper
      ->with(
        'Main information',
        array('class' => 'col-md-3')
      )
      ->add('username', TextType::class)
      ->add('email', EmailType::class)
      ->add(
        'password',
        'repeated',
        array(
          'type' => 'password',
          'options' => array('translation_domain' => 'FOSUserBundle'),
          'first_options' => array('label' => 'form.password'),
          'second_options' => array('label' => 'form.password_confirmation'),
          'invalid_message' => 'fos_user.password.mismatch',
          'mapped' => FALSE,
          'required' => FALSE,
        )
      )
      ->end()
      ->with(
        'Security information',
        array('class' => 'col-md-3')
      )
      ->add(
        'enabled',
        ChoiceType::class,
        array(
          'choices' => array(
            'Yes' => TRUE,
            'No' => FALSE,
          ),
        )
      )
      ->add(
        'roles',
        ChoiceType::class,
        array(
          'multiple' => TRUE,
          'choices' => array(
            'Admin' => 'ROLE_SUPER_ADMIN',
            'Moderator' => 'ROLE_MODERATOR',
            'User' => 'ROLE_USER',
          ),
        )
      )
      ->end()
      ->with(
        'More information',
        array('class' => 'col-md-6')
      )
      ->add(
        'name',
        TextType::class,
        array(
          'required' => FALSE,
        )
      )
      ->add(
        'soname',
        TextType::class,
        array(
          'required' => FALSE,
        )
      )
      ->add(
        'age',
        IntegerType::class,
        array(
          'required' => FALSE,
        )
      )
      ->add(
        'city',
        TextType::class,
        array(
          'required' => FALSE,
        )
      )
      ->add(
        'img',
        FileType::class,
        array(
          'mapped' => FALSE,
          'data_class' => NULL,
          'required' => FALSE,
        )
      )
      ->end();
  }

  protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
    $datagridMapper
      ->add('id')
      ->add('username')
      ->add('email')
      ->add('enabled')
      ->add('roles')
      ->add('name')
      ->add('soname')
      ->add('age')
      ->add('city');
  }

  protected function configureListFields(ListMapper $listMapper) {
    $listMapper
      ->add('id')
      ->add('username')
      ->add('email')
      ->add('enabled')
      ->add('roles')
      ->add('name')
      ->add('soname')
      ->add('age')
      ->add('city')
      ->add(
        'img',
        NULL,
        array(
          'template' => 'MainBundle:SonataAdminBundle/AdminPanel:user_list_fields.html.twig',
        )
      )
      ->add(
        '_action',
        'actions',
        [
          'actions' => [
            'edit' => [],
            'delete' => [],
          ],
        ]
      );
  }

  /**
   * @post User $object
   */
  public function preUpdate($object) {
    $this->processPassword($object);
    $this->processImage($object);
  }

  public function prePersist($object) {
    $this->processPassword($object);
    $this->processImage($object);
  }

  private function processPassword(User $object) {
    $pass = $this->getForm()->get('password')->getData();
    if ($pass !== NULL) {
      $object->setPlainPassword($pass);
    }

    $um = $this->getConfigurationPool()
      ->getContainer()
      ->get('fos_user.user_manager');
    $um->updateUser($object, FALSE);
  }

  private function processImage($object) {
    // Mapped => true $object->getImg().
    $img = $this->getForm()->get('img')->getData(); // Mapped false.
    if ($img !== NULL) {
      $fileName = md5(uniqid()) . '.' . $img->getExtension();
      $img->move(
        $this->getConfigurationPool()
          ->getContainer()
          ->getParameter('user_images'),
        $fileName
      );
      $object->setImg($fileName);
    }
  }

  public function toString($object) {
    return $object instanceof User
      ? $object->getUsername()
      : 'User';
  }
}
