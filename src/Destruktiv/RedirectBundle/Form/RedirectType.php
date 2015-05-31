<?php

namespace Destruktiv\RedirectBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RedirectType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("destination", "url", [
                "label" => false,
                "attr" => [
                    "autofocus" => true,
                    "placeholder" => "https://www.youtube.com/watch?v=dQw4w9WgXcQ"
                ]
            ])
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Destruktiv\RedirectBundle\Entity\Redirect'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'destruktiv_redirectbundle_redirect';
    }
}
