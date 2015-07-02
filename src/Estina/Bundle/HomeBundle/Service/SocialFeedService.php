<?php

namespace Estina\Bundle\HomeBundle\Service;

use Instagram\Instagram;
use NtaCamp\SocialHashtag\DataFormatter\InstagramDataFormatter;
use NtaCamp\SocialHashtag\DataFormatter\TwitterDataFormatter;
use NtaCamp\SocialHashtag\Feed\InstagramFeed;
use NtaCamp\SocialHashtag\Feed\TwitterFeed;
use NtaCamp\SocialHashtag\Post;
use NtaCamp\SocialHashtag\SocialHashtag;

class SocialFeedService
{
    private $socialHashtag;

    public function __construct(
        $twitterOauthAccessToken,
        $twitterOauthAccessTokenSecret,
        $twitterConsumerKey,
        $twitterConsumerSecret,
        $instagramClientId
    ) {
        $this->socialHashtag = new SocialHashtag('ntacamp');
        $this->socialHashtag->addFeed(new TwitterFeed(new \TwitterAPIExchange([
            'oauth_access_token' => $twitterOauthAccessToken,
            'oauth_access_token_secret' => $twitterOauthAccessTokenSecret,
            'consumer_key' => $twitterConsumerKey,
            'consumer_secret' => $twitterConsumerSecret,
        ]), new TwitterDataFormatter()));
        $instagram = new Instagram();
        $instagram->setClientID($instagramClientId);
        $this->socialHashtag->addFeed(new InstagramFeed($instagram, new InstagramDataFormatter()));
    }

    /**
     * @return Post[]
     */
    public function getFeed()
    {
        if (function_exists('apc_fetch') == false) {
            function apc_fetch($key) {
                return  false;
            }
            function apc_store($key, $value, $ttl) {
                return  false;
            }
        }

        if ($feed = apc_fetch('feed')) {
            return $feed;
        } else {
            $result = $this->socialHashtag->getResults();
            $result = array_merge($result['twitter'], $result['instagram']);
            apc_store('feed', $result, 120);

            return $result;
        }
    }
}
