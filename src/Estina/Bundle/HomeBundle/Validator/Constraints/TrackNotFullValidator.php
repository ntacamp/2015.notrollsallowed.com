<?php

namespace Estina\Bundle\HomeBundle\Validator\Constraints;

use Estina\Bundle\HomeBundle\Entity\Track;
use Estina\Bundle\HomeBundle\Service\TrackService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validate that specific Track has a space for new Talk stil.
 */
class TrackNotFullValidator extends ConstraintValidator
{
    public function __construct(TrackService $trackService)
    {
        $this->trackService = $trackService;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$value instanceof Track) {
            throw new \UnexpectedTypeException('Track entity must be provided.');
        }

        if ($this->trackService->isTrackFull($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%track%', $value)
                ->addViolation();
        }
    }
    
}
