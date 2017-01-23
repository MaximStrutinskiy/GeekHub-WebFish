<?php
namespace MainBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use MainBundle\Entity\Tag as Tag;

class TagAdmin extends Admin {
  protected function configureFormFields(FormMapper $formMapper) {
    $formMapper->add('name', TextType::class);
  }

  protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
    $datagridMapper
      ->add('id')
      ->add('name');
  }

  protected function configureListFields(ListMapper $listMapper) {
    $listMapper
      ->addIdentifier('id')
      ->addIdentifier('name');
  }

  public function toString($object) {
    return $object instanceof Tag
      ? $object->getName()
      : 'Tag'; // shown in the breadcrumb on the create view
  }
}
