<?php

namespace Irazasyed\VideoDownloader\Providers;

/**
 * Interface ProviderInterface.
 */
interface ProviderInterface
{
    public function getVideoInfo($url);
}
