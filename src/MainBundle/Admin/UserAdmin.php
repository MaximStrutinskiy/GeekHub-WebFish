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
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use MainBundle\Entity\User as User;

class UserAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with(
                'Main information',
                array('class' => 'col-md-3')
            )
            ->add('username', TextType::class)
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
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
            )
            ->end()

            ->with(
                'More information',
                array('class' => 'col-md-6')
            )
            ->add('name', TextType::class)
            ->add('soname', TextType::class)
            ->add('age', IntegerType::class)
            ->add('city', TextType::class)
            ->add(
                'img',
                FileType::class,
                array(
                    'label' => 'Upload User img (PNG file)',
                    'data_class' => null,
                    'required' => false,
                )
            )
            ->end()

        ;

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('username')
            ->add('email')
            ->add('enabled')
            ->add('roles')
            ->add('name')
            ->add('soname')
            ->add('age')
            ->add('city');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
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
                null,
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
    public function preUpdate($object)
    {
        $this->processImage($object);
    }

    public function prePersist($object)
    {
        $this->processImage($object);
    }

    private function processImage($object)
    {
        $img = $object->getImg();
        if ($img !== null) {
            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$img->getExtension();

            // Move the file to the directory where brochures are stored
            $img->move(
                $this->getConfigurationPool()->getContainer()->getParameter('user_images'),
                $fileName
            );
            // Update the 'img' property to store the img file name
            // instead of its contents
            $object->setImg($fileName);
        }
    }

    public function toString($object)
    {
        return $object instanceof User
            ? $object->getName()
            : 'User'; // shown in the breadcrumb on the create view
    }
}