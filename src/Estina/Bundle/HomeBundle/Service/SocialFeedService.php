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

    private $memcached;

    public function __construct(
        $memcached,
        $twitterOauthAccessToken,
        $twitterOauthAccessTokenSecret,
        $twitterConsumerKey,
        $twitterConsumerSecret,
        $instagramClientId
    ) {
        $this->memcached = $memcached;
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
        if ($feed = $this->memcached->get('feed')) {
            return $feed;
        } else {
            $result = $this->socialHashtag->getResults();
            $result = array_merge($result['twitter'], $result['instagram']);
            $this->memcached->set('feed', $result, 120);

            return $result;
        }
    }
}
