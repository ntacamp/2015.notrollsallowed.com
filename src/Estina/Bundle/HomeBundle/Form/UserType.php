<?php

namespace Estina\Bundle\HomeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
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
        $builder->add('facebook', 'url', [
            'label' => 'user.facebook_url',
        ]);
        $builder->add('consent', 'checkbox', [
            'label' => 'user.consent',
        ]);
        $builder->add('volunteer', 'checkbox', [
            'label' => 'user.volunteer',
            'required' => false,
        ]);
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
