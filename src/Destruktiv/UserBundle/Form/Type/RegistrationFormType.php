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

        $builder
            ->add('username', 'text', [
                "label" => "Användarnamn",
                "attr" => [
                    "placeholder" => "Användarnamn"
                ]
            ])
            ->remove('email')
            ->add('plainPassword', 'repeated', [
                'type' => 'password',
                'first_options' => [
                    'label' => 'Lösenord',
                    'attr' => [
                        "placeholder" => "Lösenord"
                    ]
                ],
                'second_options' => [
                    'label' => 'Verifiera',
                    'attr' => [
                        "placeholder" => "Lösenord (igen)"
                    ]
                ],
                'invalid_message' => 'Lösenorden matchar inte',
            ]);
    }

    public function getName()
    {
        return 'destruktiv_user_registration';
    }
}
