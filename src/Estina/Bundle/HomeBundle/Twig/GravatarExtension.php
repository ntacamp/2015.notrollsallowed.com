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
            new \Twig_SimpleFilter('gravatar', [$this, 'getGravatarImage']),
        );
    }

    /**
     * Generate url for image.
     */
    public function getGravatarImage($email, $size = 150, $rating = 'G')
    {

        $defaultImage = 'https://robohash.org/' . $this->hashEmail($email) . '.png?size=' . sprintf('%sx%s', $size, $size);
        return  $grav_url = "http://www.gravatar.com/avatar/" . $this->hashEmail($email)
            . "?s=" . $size . '&r=' . $rating . "&d=" . $defaultImage;
    }

    /**
     * @param $email
     * @return string
     */
    private function hashEmail($email)
    {
        return md5( strtolower( trim( $email ) ) );
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
