<?php

namespace ArcaSolutions\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class LoginFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'text', array(
                'label'       => 'Email',
                'attr'        => array('placeholder' => 'username@company.com'),
                'constraints' => new NotBlank(array('message' => 'Please type the your Email.'))
            ))
            ->add('password', 'password', array(
                'label'       => 'Password',
                'constraints' => new NotBlank(array('message' => 'Please type the your Password.'))
            ));
    }

    /**
     * Sets form options
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'intention'       => 'authenticate',
            'csrf_protection' => true,
        ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "edLoginForm";
    }
}