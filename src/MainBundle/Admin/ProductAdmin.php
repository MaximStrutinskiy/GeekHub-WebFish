<?php
namespace MainBundle\Admin;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
//use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use MainBundle\Entity\Product as Product;

/**
 * Class CategoryAdmin
 *
 * @package MainBundle\Admin
 */
class ProductAdmin extends Admin {

  protected function configureFormFields(FormMapper $formMapper) {

    $formMapper
      ->with(
        'Shop data 1',
        [
          'class' => 'col-md-9',
        ]
      )
      ->add(
        'shortTitle',
        TextType::class
      )
      ->add(
        'longTitle',
        TextType::class
      )
      ->add(
        'shortDescriptions',
        TextType::class
      )
      ->add(
        'longDescriptions',
        'textarea',
        [
          'attr' => ['class' => 'ckeditor'],
        ]
      )
      ->add(
        'postDate',
        DateTimeType::class
      )
      ->end()
      ->with(
        'Shop data 2',
        [
          'class' => 'col-md-3',
        ]
      )
      ->add(
        'user',
        EntityType::class,
        [
          'label' => 'Moderator',
          'class' => 'MainBundle\Entity\User',
          'query_builder' => function (EntityRepository $er) {
            return $er->createQueryBuilder('u')
                      ->where('u.roles LIKE :roles')
                      ->setParameter('roles', '%"' . 'ROLE_MODERATOR' . '"%')
                      ->orderBy('u.id', 'ASC');
          },
        ]
      )
      ->add(
        'postStatus',
        ChoiceType::class,
        [
          'choices' => [
            'Yes' => TRUE,
            'No' => FALSE,
          ],
        ]
      )
      ->add(
        'tag',
        EntityType::class,
        [
          'class' => 'MainBundle\Entity\Tag',
          'multiple' => TRUE,
          'choice_label' => 'name',
        ]
      )
      ->add(
        'category',
        'sonata_type_model',
        [
          'class' => 'MainBundle\Entity\Category',
          'property' => 'name',
        ]
      )
      ->add(
        'productPrice',
        IntegerType::class,
        [
          'label' => 'Enter Product price',
          'required' => TRUE,
        ]
      )
      ->end()
      ->with(
        'Shop data 3',
        [
          'class' => 'col-md-12',
        ]
      )
      //->add(
      //  'productImg',
      //  CollectionType::class,
      //  [
      //    'entry_type' => FileType::class,
      //    'mapped' => FALSE,
      //    'label' => 'Upload Post img (PNG file)',
      //    'data_class' => NULL,
      //    'required' => FALSE,
      //  ]
      //)
      //->add(
      //  'productImg',
      //  'sonata_type_collection',
      //  [
      //    'required' => TRUE
      //  ],
      //  [
      //    'edit' => 'inline',
      //    'inline' => 'table',
      //    'sortable' => 'position',
      //    'targetEntity' => 'Application\Sonata\MediaBundle\Entity\GalleryHasMedia',
      //    'link_parameters' => [
      //      'context' => 'attachment'
      //    ],
      //    'admin_code' => 'sonata.media.admin.gallery_has_media'
      //    // this will be your admin class service name
      //  ]
      //)

      ->add('productImg', 'sonata_type_collection', [
        'type_options' => [
          // Prevents the "Delete" option from being displayed
          'delete' => FALSE,
          'delete_options' => [
            // You may otherwise choose to put the field but hide it
            'type' => 'hidden',
            // In that case, you need to fill in the options as well
            'type_options' => [
              'mapped' => FALSE,
              'required' => FALSE,
            ]
          ]
        ]
      ], [
        'edit' => 'inline',
        'inline' => 'table',
        'sortable' => 'position',
      ])

      //->add('productImg', 'sonata_type_collection', [
      //  'type_options' => [
      //    // Prevents the "Delete" option from being displayed
      //    'delete' => FALSE,
      //    'delete_options' => [
      //      // You may otherwise choose to put the field but hide it
      //      'type' => 'hidden',
      //      // In that case, you need to fill in the options as well
      //      'type_options' => [
      //        'mapped' => FALSE,
      //        'required' => FALSE,
      //      ]
      //    ]
      //  ]
      //], [
      //  'edit' => 'inline',
      //  'inline' => 'table',
      //  'sortable' => 'position',
      //])
      //->add(
      //  'productImg', 'sonata_type_collection', [
      //  'type_options' => [
      //    // Prevents the "Delete" option from being displayed
      //    'delete' => FALSE,
      //    'delete_options' => [
      //      // You may otherwise choose to put the field but hide it
      //      'type' => 'hidden',
      //      // In that case, you need to fill in the options as well
      //      'type_options' => [
      //        'mapped' => FALSE,
      //        'required' => FALSE,
      //      ],
      //    ],
      //  ],
      //], [
      //  'edit' => 'inline',
      //  'inline' => 'table',
      //  'sortable' => 'position',
      //])
      ->end();
  }

  protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
    $datagridMapper
      ->add('id')
      ->add('shortTitle')
      ->add('shortDescriptions')
      ->add('postStatus')
      ->add('user')
      ->add('postDate');
  }

  protected function configureListFields(ListMapper $listMapper) {
    $listMapper
      ->add('id')
      ->addIdentifier('shortTitle')
      ->add('shortDescriptions')
      ->add('postStatus')
      ->add('user')
      ->add('postDate')
      //            ->add(
      //                'postImg',
      //                null,
      //                array(
      //                    'template' => 'MainBundle:SonataAdminBundle/AdminPanel:post_list_fields.html.twig',
      //                )
      //            )
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
   * @post Product $object
   */
  public function preUpdate($object) {
    $this->processImage($object);
  }

  public function prePersist($object) {
    $this->processImage($object);
  }

  private function processImage($object) {
    $img = $this->getForm()->get('productImg')->getData();
    if ($img !== NULL) {
      $fileName = md5(uniqid()) . '.' . $img->getExtension();
      $img->move(
        $this->getConfigurationPool()
             ->getContainer()
             ->getParameter('product_images'),
        $fileName
      );
      $object->setProductImg($fileName);
    }
  }

  public function toString($object) {
    return $object instanceof Product
      ? $object->getShortTitle()
      : 'Product';
  }
}
