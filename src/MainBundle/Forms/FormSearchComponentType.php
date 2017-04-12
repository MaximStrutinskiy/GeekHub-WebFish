<?php

namespace MainBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class FormSearchComponent
 * @package BlogBundle\Forms
 */
class FormSearchComponentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'searchText',
                TextType::class,
                array(
                    'attr' => array('placeholder' => 'Enter search query.'),
                    'label' => false,
                )
            );
    }
}