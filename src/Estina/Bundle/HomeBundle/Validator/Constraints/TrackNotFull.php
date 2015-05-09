<?php

namespace Estina\Bundle\HomeBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation 
 */
class TrackNotFull extends Constraint
{
    public $message = 'Scena "%track%" jau užpildyta';

    public function validatedBy()
    {
        return 'tracknotfull_validator';
    }
}
