<?php

namespace Irazasyed\VideoDownloader;

use Irazasyed\VideoDownloader\Providers\Facebook;
use Irazasyed\VideoDownloader\Providers\ProviderInterface;
use Irazasyed\VideoDownloader\Exceptions\VideoDownloaderException;

class Factory
{
    /**
     * @var ProviderInterface
     */
    protected $provider;

    /**
     * @var array Get Default Available Providers.
     */
    protected $providers = [
        'facebook' => Facebook::class
    ];

    /**
     * Factory constructor.
     *
     * @param null $provider
     */
    public function __construct($provider = null)
    {
        if(isset($provider)) {
            return $this->make($provider);
        }
    }

    /**
     * @param $provider
     *
     * @return $this
     * @throws VideoDownloaderException
     */
    public function make($provider)
    {
        if (!is_object($provider)) {

            if(array_key_exists($provider, $this->providers)) {
                $provider = $this->providers[$provider];
            } elseif (!class_exists($provider)) {
                throw new VideoDownloaderException(
                    sprintf(
                        'Provider class "%s" not found! Please make sure the class exists.',
                        $provider
                    )
                );
            }

            $provider = new $provider();
        }

        if ($provider instanceof ProviderInterface) {
            /*
             * At this stage we definitely have a proper provider to use.
             *
             * @var Provider $provider
             */
            return $this->provider = $provider;
        }

        throw new VideoDownloaderException(
            sprintf(
                'Provider class "%s" should be an instance of "Irazasyed\VideoDownloader\Providers\ProviderInterface"',
                get_class($provider)
            )
        );
    }

    /**
     * @param null $provider
     *
     * @return ProviderInterface
     */
    public function getInstance($provider = null)
    {
        if(isset($this->provider)) {
            return $this->provider;
        }

        return $this->providers[$provider];
    }


    /**
     * Add Provider to List.
     *
     * @param ProviderInterface $provider
     *
     * @return $this
     */
    public function setProvider(ProviderInterface $provider) {
        $class = get_class($provider);
        if(!array_key_exists($class, $this->providers)) {
            $this->providers[$class] = $provider;
        }

        return $this;
    }

    /**
     * Returns Current Provider Instance
     */
    public function getProvider()
    {
        return $this->provider;
    }
}