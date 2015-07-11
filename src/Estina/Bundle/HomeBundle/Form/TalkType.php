<?php

namespace Estina\Bundle\HomeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TalkType extends AbstractType
{
    const ADD_USER_FIELDS = true;
    const NO_USER_FIELDS = false;

    const SHOW_TRACK_FIELD = true;
    const HIDE_TRACK_FIELD = false;
    
    /** @var boolean should user fields be included in form? */
    private $includeUserFields;

    /** @var boolean show track field? */
    private $showTrackField;

    /**
     * @param boolean $includeUserFields should user fields be included in form?
     */
    public function __construct(
        $includeUserFields = self::ADD_USER_FIELDS,
        $showTrackField = self::SHOW_TRACK_FIELD
    ) {
        $this->includeUserFields = $includeUserFields;
        $this->showTrackField = $showTrackField;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($this->includeUserFields === self::ADD_USER_FIELDS) {
            $builder
                ->add('user', new UserType(), ['label' => false])
            ;
        }

        $builder
            ->add('title','text', ['label' => 'Pranešimo pavadinimas'])
            ->add('description', 'textarea', ['label' => 'Trumpas aprašymas'])
            ->add('slides', 'file', [
                'label' => 'Prezentacijos skaidrės',
                'required' => false,
                'data_class' => null
            ])
        ;
        if ($this->showTrackField) {
            $builder->add('track', null, ['label' => 'Scena']);
        }
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
