<?php
//namespace MainBundle\Admin;
//
//use Doctrine\ORM\EntityRepository;
//use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
//use Sonata\AdminBundle\Datagrid\ListMapper;
//use Sonata\AdminBundle\Datagrid\DatagridMapper;
//use Sonata\AdminBundle\Form\FormMapper;
//use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
//use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
//use Symfony\Component\Form\Extension\Core\Type\FileType;
//use Symfony\Component\Form\Extension\Core\Type\TextType;
//use Symfony\Bridge\Doctrine\Form\Type\EntityType;
//use MainBundle\Entity\Post as Post;
//
///**
// * Class CategoryAdmin
// *
// * @package MainBundle\Admin
// */
//class ProductAdmin extends Admin
//{
//
//    protected function configureFormFields(FormMapper $formMapper)
//    {
//        $formMapper
//            ->with(
//                'Blog data 1',
//                array(
//                    'class' => 'col-md-9',
//                )
//            )
//            ->add(
//                'shortTitle',
//                TextType::class
//            )
//            ->add(
//                'longTitle',
//                TextType::class
//            )
//            ->add(
//                'shortDescriptions',
//                TextType::class
//            )
//            ->add(
//                'longDescriptions',
//                'textarea',
//                array(
//                    'attr' => array('class' => 'ckeditor'),
//                )
//            )
//            ->add(
//                'postDate',
//                DateTimeType::class
//            )
//            ->end()
//            ->with(
//                'Blog data 2',
//                array(
//                    'class' => 'col-md-3',
//                )
//            )
//            ->add(
//                'user',
//                EntityType::class,
//                array(
//                    'label' => 'Moderator',
//                    'class' => 'MainBundle\Entity\User',
//                    'query_builder' => function (EntityRepository $er) {
//                        return $er->createQueryBuilder('u')
//                            ->where('u.roles LIKE :roles')
//                            ->setParameter('roles', '%"'.'ROLE_MODERATOR'.'"%')
//                            ->orderBy('u.id', 'ASC');
//                    },
//                )
//            )
//            ->add(
//                'postStatus',
//                ChoiceType::class,
//                array(
//                    'choices' => array(
//                        'Yes' => true,
//                        'No' => false,
//                    ),
//                )
//            )
//            ->add(
//                'tag',
//                EntityType::class,
//                array(
//                    'class' => 'MainBundle\Entity\Tag',
//                    'multiple' => true,
//                    'choice_label' => 'name',
//                )
//            )
//            ->add(
//                'category',
//                'sonata_type_model',
//                array(
//                    'class' => 'MainBundle\Entity\Category',
//                    'property' => 'name',
//                )
//            )
//            ->add(
//                'postImg',
//                FileType::class,
//                array(
//                    'mapped' => false,
//                    'label' => 'Upload Post img (PNG file)',
//                    'data_class' => null,
//                    'required' => false,
//                )
//            )
//            ->end();
//    }
//
//    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
//    {
//        $datagridMapper
//            ->add('id')
//            ->add('shortTitle')
//            ->add('shortDescriptions')
//            ->add('postStatus')
//            ->add('user')
//            ->add('postDate');
//    }
//
//    protected function configureListFields(ListMapper $listMapper)
//    {
//        $listMapper
//            ->add('id')
//            ->addIdentifier('shortTitle')
//            ->add('shortDescriptions')
//            ->add('postStatus')
//            ->add('user')
//            ->add('postDate')
//            ->add(
//                'postImg',
//                null,
//                array(
//                    'template' => 'MainBundle:SonataAdminBundle/AdminPanel:post_list_fields.html.twig',
//                )
//            )
//            ->add(
//                '_action',
//                'actions',
//                [
//                    'actions' => [
//                        'edit' => [],
//                        'delete' => [],
//                    ],
//                ]
//            );
//    }
//
//    /**
//     * @post Post $object
//     */
//    public function preUpdate($object)
//    {
//        $this->processImage($object);
//    }
//
//    public function prePersist($object)
//    {
//        $this->processImage($object);
//    }
//
//    private function processImage($object)
//    {
//        $img = $this->getForm()->get('postImg')->getData();
//        if ($img !== null) {
//            $fileName = md5(uniqid()).'.'.$img->getExtension();
//            $img->move(
//                $this->getConfigurationPool()
//                    ->getContainer()
//                    ->getParameter('post_images'),
//                $fileName
//            );
//            $object->setPostImg($fileName);
//        }
//    }
//
//    public function toString($object)
//    {
//        return $object instanceof Post
//            ? $object->getShortTitle()
//            : 'Post';
//    }
//}