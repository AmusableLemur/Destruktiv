<?php

namespace Destruktiv\ForumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ThreadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', [
                "label" => false,
                "attr" => [
                    "placeholder" => "Titel"
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
            'data_class' => 'Destruktiv\ForumBundle\Entity\Thread'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'destruktiv_forumbundle_thread';
    }
}
