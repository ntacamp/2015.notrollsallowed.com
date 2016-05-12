<?php

namespace Estina\Bundle\HomeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Register talk.
 */
class RegisterTalkType extends AbstractType
{
    private $addUser = true;

    public function __construct($addUser = true)
    {
        $this->addUser = $addUser;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($this->addUser) {
            $builder->add('user', new UserType(), ['label' => false]);
        }
        $builder
            ->add('language', 'choice', [
                'label' => 'Pranešimo kalba',
                'choices' => ['LT' => 'LT', 'EN' => 'EN'],
                'label_attr' => ['text_en' => 'presentation language']
            ])
            ->add('title', 'text', [
                'label' => 'Pranešimo tema',
                'label_attr' => ['text_en' => 'talk title']
            ])
            ->add('description', 'textarea', [
                'label' => 'Pranešimo aprašymas',
                'label_attr' => ['text_en' => 'talk description']
            ])
            ->add('track', null, [
                'label' => 'Scena', 
                'required' => false,
                'label_attr' => ['text_en' => 'scene']
            ])
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Estina\Bundle\HomeBundle\Entity\Talk'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'estina_bundle_homebundle_registertalk';
    }
}
