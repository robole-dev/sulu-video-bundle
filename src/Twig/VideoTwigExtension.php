<?php

namespace Robole\SuluVideoBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class VideoTwigExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('video_embed_url', [$this, 'getVideoEmbedUrl']),
            new TwigFunction('video_provider', [$this, 'getVideoProvider'])
        ];
    }

    /**
     * Transforms a full video URL into an iframe-friendly embed-URL.
     */
    public function getVideoEmbedUrl(string $url): string
    {
        // Vimeo
        if (false !== strpos($url, 'vimeo.com')) {
            $url = str_replace('vimeo.com', 'player.vimeo.com/video', $url);
            $url .= (false !== strpos($url, '?') ? '&' : '?') . 'dnt=1';

            return $url;
        }

        // Dailymotion
        if (false !== strpos($url, 'dailymotion.com')) {
            $url = str_replace('dailymotion.com', 'dailymotion.com/embed', $url);

            return $url;
        }

        // YouTube
        if (false !== strpos($url, 'youtu.be')) {
            $url = str_replace('youtu.be', 'www.youtube.com/embed', $url);
        }

        if (false !== strpos($url, 'youtube.com/watch?v=')) {
            $url = str_replace('watch?v=', 'embed/', $url);
        }

        if (false !== strpos($url, 'shorts/')) {
            // Shorts don't support "youtube-nocookie.com"
            return str_replace('shorts/', 'embed/', $url);
        }

        if (false !== strpos($url, 'youtube.com')) {
            $url = str_replace('youtube.com', 'youtube-nocookie.com', $url);
        }

        return $url;
    }

    /**
     * Guess the video provider type.
     */
    public function getVideoProvider(string $url): ?string
    {
        if (false !== strpos($url, 'vimeo.com')) {
            return 'vimeo';
        }

        if (false !== strpos($url, 'dailymotion.com')) {
            return 'dailymotion';
        }

        if (false !== strpos($url, 'youtu.be') || false !== strpos($url, 'youtube.com')) {
            return 'youtube';
        }

        return null;
    }
}
