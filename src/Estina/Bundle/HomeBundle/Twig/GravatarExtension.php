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
    public function getGravatarImage($email, $size = 150, $rating = 'G')
    {

        $defaultImage = 'https://robohash.org/' . $email . '?size=120x120';
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
