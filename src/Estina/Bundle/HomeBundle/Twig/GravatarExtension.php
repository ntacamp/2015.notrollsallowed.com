<?php

namespace Estina\Bundle\HomeBundle\Twig;

/**
 * Gravatar 
 */
class GravatarExtension extends \Twig_Extension
{
    /**
     * Return registered filters 
     * 
     * @return array
     */
    public function getFilters()
    {
        return array(
            'gravatar' => new \Twig_Filter_Method($this, 'getGravatarImage'),
        );
    }

    /**
     * Generate url for image. 
     */
    public function getGravatarImage($email, $size = 150, $defaultImage = 'http://2014.notrollsallowed.com/images/demo/speakers/speaker-01.jpg', $rating = 'G')
    {
        return  $grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) )
            . "?d=" . urlencode( $defaultImage ) . "&s=" . $size . '&r=' . $rating;
    }

    /**
     * Name 
     * 
     * @return string
     */
    public function getName()
    {
        return 'gravatar';
    }

}
