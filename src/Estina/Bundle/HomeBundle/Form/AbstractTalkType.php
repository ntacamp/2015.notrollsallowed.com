<?php

namespace Estina\Bundle\HomeBundle\Form;

use Estina\Bundle\HomeBundle\Entity\Talk;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class AbstractTalkType extends AbstractType
{
    protected $talkTypes = [
        'registration.form.type_presentation',
        'registration.form.type_workshop',
        'registration.form.type_other'
    ];

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'choice', [
                'label' => 'registration.form.type',
                'choices' => array_combine(Talk::getTypesMap(), $this->talkTypes),
            ])
            ->add('title', 'text', [
                'label' => 'registration.form.name',
            ])
            ->add('language', 'choice', [
                'label' => 'registration.form.language',
                'choices' => ['LT' => 'LT', 'EN' => 'EN'],
            ])
            ->add('description', 'textarea', [
                'label' => 'registration.form.description',
            ])
            ->add('requirements', 'textarea', [
                'label' => 'registration.form.requirements',
                'required' => false,
            ])
            ->add('comments', 'textarea', [
                'label' => 'registration.form.comments',
                'required' => false,
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
}
