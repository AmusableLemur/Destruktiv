<?php

namespace Destruktiv\UserBundle\Form\Type;

use FOS\UserBundle\Form\Type\RegistrationFormType as BaseRegistrationFormType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

class RegistrationFormType extends BaseRegistrationFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('invitation', 'destruktiv_invitation_type');
    }

    public function getName()
    {
        return 'destruktiv_user_registration';
    }
}