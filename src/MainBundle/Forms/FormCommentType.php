<?php

namespace MainBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class FormInfo
 * Use BlogBundle\Entity\Info
 * @package BlogBundle\Forms
 */
class FormCommentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'commentText',
                TextareaType::class,
                array(
                    'attr' => array('placeholder' => 'Enter your commit'),
                    'label' => false,
                )
            )
            ->add(
                'send',
                SubmitType::class,
                array(
                    'attr' => array(
                        'class' => 'waves-effect waves-light btn',
                    ),
                )
            )
            ->add(
                'clean',
                ResetType::class,
                array(
                    'attr' => array(
                        'class' => 'waves-effect waves-light btn',
                    ),
                )
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'MainBundle\Entity\Comment',
            ]
        );
    }
}
