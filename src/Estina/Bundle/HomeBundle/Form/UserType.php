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
        $builder->add('name', 'text', [
            'label' => 'user.fullname',
        ]);
        $builder->add('email', 'email', [
            'label' => 'user.email',
        ]);
        $builder->add('phone', 'text', [
            'label' => 'user.phone',
        ]);
        
        if ($this->addAdditionalFields) {
            $builder->add(
                'twitter', 
                'text', 
                [
                    'label' => 'Twitter',
                    'required' => false
                ]
            );
            $builder->add(
                'github', 
                'text', 
                [
                    'label' => 'GitHub',
                    'required' => false
                ]
            );
            $builder->add(
                'facebook', 
                'url',
                [
                    'label' => 'Facebook URL',
                    'required' => false
                ]
            );
            $builder->add(
                'linkedin', 
                'url',
                [
                    'label' => 'Linkedin URL',
                    'required' => false
                ]
            );
            $builder->add(
                'blog', 
                'url',
                [
                    'label' => 'Blog URL',
                    'required' => false
                ]
            );
            $builder->add(
                'homepage', 
                'url',
                [
                    'label' => 'user.homepage_url',
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
