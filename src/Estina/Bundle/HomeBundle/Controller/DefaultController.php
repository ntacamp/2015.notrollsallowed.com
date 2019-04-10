<?php

namespace Estina\Bundle\HomeBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * DefaultController
 */
class DefaultController extends Controller
{
    
    function filter_images($filename) {

        if (strpos($filename, '.jpg') !== false) {
            return true;
        }

        return false;
    }

    /**
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction() {
        $dir    = '../web/images/photos';
        $photos = scandir($dir);

        $photos = array_filter($photos, array($this, "filter_images"));

        return [
            'feed' => $this->get('home.social_feed_service')->getFeed(),
            'photos' => $photos,
        ];
    }


}
