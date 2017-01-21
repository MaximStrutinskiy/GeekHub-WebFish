<?php

namespace MainBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use MainBundle\Entity\User as User;

class UserAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('username', TextType::class)
            ->add('email', EmailType::class)
            ->add(
                'enabled',
                ChoiceType::class,
                array(
                    'choices' => array(
                        'Yes' => true,
                        'No' => false,
                    ),
                )
            )
            ->add(
                'roles',
                ChoiceType::class,
                array(
                    'multiple' => true,
                    'choices' => array(
                        'Admin' => 'ROLE_SUPER_ADMIN',
                        'User' => 'ROLE_USER',
                    ),
                )
            );
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('username')
            ->add('email')
            ->add('enabled')
            ->add('roles');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('username')
            ->addIdentifier('email')
            ->add('enabled')
            ->add('roles')
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

    public function toString($object)
    {
        return $object instanceof User
            ? $object->getName()
            : 'User'; // shown in the breadcrumb on the create view
    }
}