<?php

namespace Irazasyed\VideoDownloader\Providers;

use Irazasyed\VideoDownloader\Exceptions\VideoDownloaderException;

/**
 * Class Facebook.
 */
class Facebook extends Provider
{
    /**
     * Generate URL based on Video ID/Link.
     *
     * @param $url
     *
     * @return string
     */
    public function generateUrl($url)
    {
        $id = '';
        if (is_int($url)) {
            $id = $url;
        } elseif (preg_match('/(?:\.?\d+)(?:\/videos)?\/?(\d+)?(?:[v]\=)?(\d+)?/i', $url, $matches)) {
            $id = $matches[1];
        }

        return 'https://www.facebook.com/video.php?v='.$id;
    }

    /**
     * Gets Video Download Links with Meta Data.
     * Returns HD & SD Quality Links.
     *
     * @param $url
     *
     * @throws VideoDownloaderException
     *
     * @return array
     */
    public function getVideoInfo($url)
    {
        $this->getSourceCode($this->generateUrl($url));

        $title = $this->getTitle();

        if (strtolower($title) === "sorry, this content isn't available at the moment") {
            throw new VideoDownloaderException('Video not available!');
        }

        $description = $this->getDescription();
        $owner = $this->getValueByKey('ownerName');
        $created_time = $this->getCreatedTime();
        $hd_link = $this->getValueByKey('hd_src_no_ratelimit');
        $sd_link = $this->getValueByKey('sd_src_no_ratelimit');

        return compact('title', 'description', 'owner', 'created_time', 'hd_link', 'sd_link');
    }

    /**
     * Get Video Title.
     *
     * @return string|null
     */
    public function getTitle()
    {
        $title = null;
        if (preg_match('/h2 class="uiHeaderTitle"?[^>]+>(.+?)<\/h2>/', $this->body, $matches)) {
            $title = $matches[1];
        } elseif (preg_match('/title id="pageTitle">(.+?)<\/title>/', $this->body, $matches)) {
            $title = $matches[1];
        }

        return $this->cleanStr($title);
    }

    /**
     * Get Description.
     *
     * @return string|bool
     */
    public function getDescription()
    {
        if (preg_match('/span class="hasCaption">(.+?)<\/span>/', $this->body, $matches)) {
            return $this->cleanStr($matches[1]);
        }

        return false;
    }

    /**
     * Get Created Time in Unix.
     *
     * @return string
     */
    public function getCreatedTime()
    {
        if (preg_match('/data-utime="(.+?)"/', $this->body, $matches)) {
            return $matches[1];
        }

        return false;
    }

    /**
     * Get Value By Key Name.
     *
     * @param $key
     *
     * @return string|bool
     */
    public function getValueByKey($key)
    {
        if (preg_match('/"'.$key.'":"(.*?)"/i', $this->body, $matches)) {
            $str = $this->decodeUnicode($matches[1]);

            return stripslashes(rawurldecode($str));
        }

        return false;
    }
}
