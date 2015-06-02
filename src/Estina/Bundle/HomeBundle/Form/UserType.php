<?php

namespace Estina\Bundle\HomeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    const ADD_ADDITIONAL_FIELDS = true;
    const NO_ADDITIONAL_FIELDS = false;

    /** @var boolean should additional fields be included in form? */
    private $addAdditionalFields;

    /**
     * @param boolean $addAdditionalFields should additional fields be included in form?
     */
    public function __construct($addAdditionalFields = self::NO_ADDITIONAL_FIELDS)
    {
        $this->addAdditionalFields = $addAdditionalFields;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', ['label' => 'Vardas/Pavardė']);
        $builder->add('email', 'email', ['label' => 'El. Paštas']);
        $builder->add('phone', 'text', ['label' => 'Telefonas']);
        $builder->add(
            'twitter', 
            'text', 
            [
                'label' => 'Twitter name',
                'required' => false
            ]
        );
        $builder->add(
            'github', 
            'text', 
            [
                'label' => 'GitHub name',
                'required' => false
            ]
        );
        if ($this->addAdditionalFields) {
            $builder->add(
                'facebook', 
                'text', 
                [
                    'label' => 'Facebook URL',
                    'required' => false
                ]
            );
            $builder->add(
                'gplus', 
                'text', 
                [
                    'label' => 'Google+ URL',
                    'required' => false
                ]
            );
            $builder->add(
                'linkedin', 
                'text', 
                [
                    'label' => 'Linkedin URL',
                    'required' => false
                ]
            );
            $builder->add(
                'blog', 
                'text', 
                [
                    'label' => 'Blog URL',
                    'required' => false
                ]
            );
            $builder->add(
                'homepage', 
                'text', 
                [
                    'label' => 'Asmeninio puslapio URL',
                    'required' => false
                ]
            );
        }
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Estina\Bundle\HomeBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'estina_bundle_home_registration';
    }
}
