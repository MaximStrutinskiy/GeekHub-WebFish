<?php
/**
 * Created by PhpStorm.
 * User: alpha
 * Date: 24.01.17
 * Time: 15:27
 */

namespace MainBundle\Forms\FOSUserBundle;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class FormEditType
 *
 * @package MainBundle\Forms\FOSUserBundle
 */
class FormEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                array(
                    'required' => false,
                )
            )
            ->add(
                'soname',
                TextType::class,
                array(
                    'required' => false,
                )
            )
            ->add(
                'email',
                EmailType::class,
                array(
                    'required' => false,
                )
            )
            ->add(
                'age',
                TextType::class,
                array(
                    'required' => false,
                )
            )
            ->add(
                'city',
                TextType::class,
                array(
                    'required' => false,
                )
            )
            ->add(
                'img',
                FileType::class,
                array(
                    'label' => 'Upload you img (PNG file)',
                    'required' => false,
                    'data_class' => null,
                    'mapped' => false,
                )
            );
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_edit';
    }
}
