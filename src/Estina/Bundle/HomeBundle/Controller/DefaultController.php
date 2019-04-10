<?php

namespace Estina\Bundle\HomeBundle\Controller;

use Estina\Bundle\HomeBundle\Form\TalkType;
use Estina\Bundle\HomeBundle\Event\TalkEvent;
use Estina\Bundle\HomeBundle\EventListener\TalkListener;
use Estina\Bundle\HomeBundle\TalkEvents;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\Translation\Translator;

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
