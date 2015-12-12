<?php

namespace Irazasyed\VideoDownloader\Providers;

/**
 * Interface ProviderInterface
 *
 * @package Irazasyed\VideoDownloader\Providers
 */
interface ProviderInterface
{
    public function getVideoInfo($url);
}