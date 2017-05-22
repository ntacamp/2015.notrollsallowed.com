<?php

namespace Estina\Bundle\HomeBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * Register talk.
 */
class RegisterTalkType extends AbstractTalkType
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
        parent::buildForm($builder, $options);

        if ($this->addUser) {
            $builder->add('user', new UserType(), ['label' => false]);
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'estina_bundle_homebundle_registertalk';
    }
}
