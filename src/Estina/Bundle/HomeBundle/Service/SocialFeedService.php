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
        $instagramClientId,
        $enabled,
        array $excludeUsers
    ) {
        $this->twitterOauthAccessToken = $twitterOauthAccessToken;
        $this->twitterOauthAccessTokenSecret = $twitterOauthAccessTokenSecret;
        $this->twitterConsumerKey = $twitterConsumerKey;
        $this->twitterConsumerSecret = $twitterConsumerSecret;
        $this->instagramClientId = $instagramClientId;
        $this->enabled = $enabled;
        $this->excludeUsers = $excludeUsers;
    }

    /**
     * @return socialHashtag
     */
    private function getService()
    {
        if (null === $this->socialHashtag) {
            $this->socialHashtag = new SocialHashtag('ntacamp');
            $this->socialHashtag->addFeed(new TwitterFeed(new \TwitterAPIExchange([
                'oauth_access_token' => $this->twitterOauthAccessToken,
                'oauth_access_token_secret' => $this->twitterOauthAccessTokenSecret,
                'consumer_key' => $this->twitterConsumerKey,
                'consumer_secret' => $this->twitterConsumerSecret,
            ]), new TwitterDataFormatter(['includeRetweets' => false])));
            $instagram = new Instagram();
            $instagram->setClientID($this->instagramClientId);
            $this->socialHashtag->addFeed(new InstagramFeed($instagram, new InstagramDataFormatter()));
        }

        return $this->socialHashtag;
    }

    /**
     * @return Post[]
     */
    public function getFeed()
    {
        if (false === $this->enabled) {
            return false;
        }

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
            $result = $this->getService()->getResults();
            $result = array_merge($result['twitter'], $result['instagram']);
            $result = array_filter($result, function(Post $post){
               return !in_array($post->getUsername(), $this->excludeUsers);
            });
            usort($result, function(Post $first, Post $second){
                return $first->getDate() > $second->getDate() ? -1 : 1;
            });
            apc_store('feed', $result, 120);

            return $result;
        }
    }
}
