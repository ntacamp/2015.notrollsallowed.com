<?php

namespace Estina\Bundle\HomeBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

class TalkType extends AbstractTalkType
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
        parent::buildForm($builder, $options);

        if ($this->includeUserFields === self::ADD_USER_FIELDS) {
            $builder
                ->add('user', new UserType(), ['label' => false])
            ;
        }

        if ($this->showTrackField) {
            $builder->add('track', null, [
                'label' => 'Stage', 
                'required' => false,
            ]);
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'estina_bundle_homebundle_talk';
    }
}
