<?php

namespace ArcaSolutions\WebBundle\Form\Type;

use ArcaSolutions\WebBundle\Entity\Accountprofilecontact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReviewsType extends AbstractType
{
    /**
     * @var Accountprofilecontact
     */
    private $account;

    function __construct($account = null)
    {
        $this->account = $account;
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($this->account) {
            $name = $this->account->getFirstName();
            $email = null;
        } else {
            $name = null;
            $email = null;
        }

        $builder
            ->add('name', 'text', [
                'label'       => 'Name',
                'attr'        => ['placeholder' => 'Name'],
                'data'        => $name,
                'constraints' => new NotBlank(['message' => 'Please type your Name.']),
            ])
            ->add('title', 'text', [
                'label'       => 'Review Title',
                'attr'        => ['placeholder' => 'Type a title for your comment'],
                'constraints' => new NotBlank(['message' => 'Please type an title for your review.']),
            ])
            ->add('email', 'text', [
                'label'       => 'Email',
                'data'        => $email,
                'attr'        => ['placeholder' => 'Contact e-mail'],
                'constraints' => [
                    new NotBlank(['message' => 'Please type your e-mail address.']),
                    new Email(['message' => 'Please enter a valid e-mail address']),
                ],
            ])
            ->add('location', 'text', [
                'label'       => 'City, State',
                'attr'        => ['placeholder' => 'Location'],
                'constraints' => new NotBlank(['message' => 'Please type your Location.']),
            ])
            ->add('message', 'textarea', [
                'label'       => 'Write a review',
                'attr'        => ['rows' => 15],
                'constraints' => new NotBlank(['message' => 'Please type the message.']),
            ])
            ->add('rating', 'hidden', [
                'required'    => true,
                'constraints' => new NotBlank(['message' => 'Please type the rating.']),
            ])
            ->add('captcha', 'captcha', []); }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'edirReviews';
    }
}
