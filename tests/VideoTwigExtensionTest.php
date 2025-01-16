<?php

namespace Robole\SuluVideoBundle\Tests;

use PHPUnit\Framework\TestCase;
use Robole\SuluVideoBundle\Twig\VideoTwigExtension;

class VideoTwigExtensionTest extends TestCase
{
    public function testGetVideoEmbedUrl()
    {
        $extension = new VideoTwigExtension();

        // Test Vimeo URL
        $vimeoUrl = 'https://vimeo.com/76979871';
        $expectedVimeoUrl = 'https://player.vimeo.com/video/76979871?dnt=1';
        $this->assertEquals($expectedVimeoUrl, $extension->getVideoEmbedUrl($vimeoUrl));

        // Test Vimeo URL with optional params
        $vimeoUrl = 'https://vimeo.com/76979871?param=x';
        $expectedVimeoUrl = 'https://player.vimeo.com/video/76979871?param=x&dnt=1';
        $this->assertEquals($expectedVimeoUrl, $extension->getVideoEmbedUrl($vimeoUrl));

        // Test YouTube URL
        $youtubeUrl = 'https://www.youtube.com/watch?v=aqz-KE-bpKQ';
        $expectedYoutubeUrl = 'https://www.youtube-nocookie.com/embed/aqz-KE-bpKQ';
        $this->assertEquals($expectedYoutubeUrl, $extension->getVideoEmbedUrl($youtubeUrl));

        // Test YouTube short URL (youtu.be)
        $youtubeUrl = 'https://youtu.be/aqz-KE-bpKQ';
        $expectedYoutubeUrl = 'https://www.youtube-nocookie.com/embed/aqz-KE-bpKQ';
        $this->assertEquals($expectedYoutubeUrl, $extension->getVideoEmbedUrl($youtubeUrl));

        // Test YouTube URL with optional params
        $youtubeUrl = 'https://www.youtube.com/watch?v=aqz-KE-bpKQ?feature=share';
        $expectedYoutubeUrl = 'https://www.youtube-nocookie.com/embed/aqz-KE-bpKQ?feature=share';
        $this->assertEquals($expectedYoutubeUrl, $extension->getVideoEmbedUrl($youtubeUrl));

        // Test Dailymotion URL
        $dailymotionUrl = 'https://www.dailymotion.com/video/x92td94';
        $expectedDailymotionUrl = 'https://www.dailymotion.com/embed/video/x92td94';
        $this->assertEquals($expectedDailymotionUrl, $extension->getVideoEmbedUrl($dailymotionUrl));
    }


    public function testGetVideoProvider()
    {
        $extension = new VideoTwigExtension();

        // Test Vimeo URL
        $vimeoUrl = 'https://vimeo.com/76979871';
        $expectedVimeoProvider = 'vimeo';
        $this->assertEquals($expectedVimeoProvider, $extension->getVideoProvider($vimeoUrl));

        // Test YouTube URL
        $youtubeUrl = 'https://www.youtube.com/watch?v=pbTO0w-fWKE';
        $expectedYoutubeProvider = 'youtube';
        $this->assertEquals($expectedYoutubeProvider, $extension->getVideoProvider($youtubeUrl));

        // Test YouTube short URL (youtu.be)
        $youtubeShortUrl = 'https://youtu.be/pbTO0w-fWKE';
        $this->assertEquals($expectedYoutubeProvider, $extension->getVideoProvider($youtubeShortUrl));

        // Test Dailymotion URL
        $dailymotionUrl = 'https://www.dailymotion.com/video/x92td94';
        $expectedDailymotionProvider = 'dailymotion';
        $this->assertEquals($expectedDailymotionProvider, $extension->getVideoProvider($dailymotionUrl));

        // Test unknown URL
        $unknownUrl = 'https://example.com/video/12345.mp4';
        $expectedUnknownProvider = null;
        $this->assertEquals($expectedUnknownProvider, $extension->getVideoProvider($unknownUrl));
    }
}
