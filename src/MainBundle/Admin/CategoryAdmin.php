<?php
namespace MainBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use MainBundle\Entity\Category as Category;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class CategoryAdmin
 *
 * @package MainBundle\Admin
 */
class CategoryAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', TextType::class)
            ->add('description', TextType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('description');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('name')
            ->add('description')
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
        return $object instanceof Category
            ? $object->getName()
            : 'Category';
    }
}
