<?php

namespace Estina\Bundle\HomeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TalkType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', ['attr' => [
                'placeholder' => 'Pranešimo pavadinimas',
            ]])
            ->add('description', 'text', ['attr' => [
                'placeholder' => 'Aprašymas'
            ]])
            ->add('speaker', 'text', ['attr' => [
                'placeholder' => 'Vardas, pavardė'
            ]])
            ->add('email', 'email', ['attr' => [
                'placeholder' => 'El. paštas'
            ]])
            ->add('phone', 'text', ['attr' => [
                'placeholder' => 'Telefono nr.'
            ]])
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
        return 'estina_bundle_homebundle_talk';
    }
}
