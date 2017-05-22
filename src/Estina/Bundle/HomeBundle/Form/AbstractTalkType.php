<?php

namespace Estina\Bundle\HomeBundle\Form;

use Estina\Bundle\HomeBundle\Entity\Talk;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class AbstractTalkType extends AbstractType
{
    protected $tshirtSizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'];

    protected $tshirtModels = ['unisex', 'women'];

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'choice', [
                'label' => 'Type of presentation',
                'choices' => Talk::getTypesMap(),
            ])
            ->add('title', 'text', [
                'label' => 'Complete title',
            ])
            ->add('language', 'choice', [
                'label' => 'Presentation language',
                'choices' => ['LT' => 'LT', 'EN' => 'EN'],
            ])
            ->add('description', 'textarea', [
                'label' => 'Talk description',
            ])
            ->add('requirements', 'textarea', [
                'label' => 'Requirements for attendees',
                'required' => false,
            ])
            ->add('comments', 'textarea', [
                'label' => 'Comments/special requests',
                'required' => false,
            ])
            ->add('tshirtModel', 'choice', [
                'label' => 'T-shirt model',
                'choices' => array_combine(
                    $this->tshirtModels, array_map("ucfirst", $this->tshirtModels)),
            ])
            ->add('tshirtSize', 'choice', [
                'label' => 'T-shirt size',
                'choices' => array_combine($this->tshirtSizes, $this->tshirtSizes),
            ])
            ->add('question1', 'text', [
                'label' => 'What can you teach other No Trolls Allowed attendees in 5 minutes?',
            ])
            ->add('question2', 'text', [
                'label' => 'How can you contribute to No Trolls Allowed event?',
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
