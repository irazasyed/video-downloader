<?php

namespace Irazasyed\VideoDownloader\Providers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\RequestOptions;
use Irazasyed\VideoDownloader\Exceptions\VideoDownloaderException;

/**
 * Abstract Provider.
 */
abstract class Provider implements ProviderInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var PromiseInterface[]
     */
    private static $promises = [];

    /**
     * @var string
     */
    protected $body;

    /**
     * VideoLinkGenerator constructor.
     *
     * @param Client|null $client
     */
    public function __construct(Client $client = null)
    {
        $this->client = $client ?: new Client();
    }

    /**
     * Unwrap Promises.
     */
    public function __destruct()
    {
        Promise\unwrap(self::$promises);
    }

    /**
     * @param $url
     */
    abstract public function getVideoInfo($url);

    /**
     * Sets HTTP client.
     *
     * @param $client
     *
     * @return $this
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Gets HTTP client for internal class use.
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Returns Raw Response Body.
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Get Page Source Code.
     *
     * @param $url
     *
     * @throws VideoDownloaderException
     */
    public function getSourceCode($url)
    {
        $response = $this->httpRequest($url);

        $status = $response->getStatusCode();

        if ($status === 200) {
            return $this->body = $response->getBody();
        }

        throw new VideoDownloaderException('Something went wrong, HTTP Status Code Returned: '.$status);
    }

    /**
     * Download remote file from server
     * and save it locally using HTTP Client.
     *
     * @param string $url            The URL to Remote File to Download.
     * @param string $dstFilename    Destination Filename (Accepts File Path too).
     * @param bool   $isAsyncRequest
     *
     * @return string
     */
    public function download($url, $dstFilename, $isAsyncRequest = false)
    {
        $baseDir = dirname($dstFilename);
        if (!is_writable($baseDir)) {
            @mkdir($baseDir, 0755, true);
        }

        $this->httpRequest($url, ['sink' => $dstFilename], $isAsyncRequest);

        return ['file_path' => $dstFilename];
    }

    /**
     * Make a HTTP Request.
     *
     * @param            $url
     * @param array      $options
     * @param bool|false $isAsyncRequest
     *
     * @return mixed
     */
    private function httpRequest($url, array $options = [], $isAsyncRequest = false)
    {
        if ($url == null || trim($url) == '') {
            return 'URL was invalid.';
        }

        $options = $this->getOptions($this->defaultHeaders(), $options, $isAsyncRequest);

        try {
            $response = $this->client->getAsync($url, $options);

            if ($isAsyncRequest) {
                self::$promises[] = $response;
            } else {
                $response = $response->wait();
            }
        } catch (RequestException $e) {
            return 'There was an error while processing the request';
        }

        return $response;
    }

    /**
     * Prepares and returns request options.
     *
     * @param array $headers
     * @param       $options
     * @param       $isAsyncRequest
     *
     * @return array
     */
    private function getOptions(array $headers, $options = [], $isAsyncRequest = false)
    {
        $default_options = [
            RequestOptions::HEADERS     => $headers,
            RequestOptions::SYNCHRONOUS => !$isAsyncRequest,
        ];

        return array_merge($default_options, $options);
    }

    /**
     * Returns Default Headers for HTTP Client.
     *
     * @return array
     */
    protected function defaultHeaders()
    {
        return [
            'User-Agent'      => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.71 Safari/537.36',
            'Accept-Language' => 'en-US,en;q=0.8,sr;q=0.6,pt;q=0.4',
        ];
    }

    /**
     * Decode Unicode Sequences.
     *
     * @param $str
     *
     * @return mixed
     */
    protected function decodeUnicode($str)
    {
        return preg_replace_callback(
            '/\\\\u([0-9a-f]{4})/i',
            [$this, 'replace_unicode_escape_sequence'],
            $str
        );
    }

    /**
     * Cleanup string to readible text.
     *
     * @param string $str
     *
     * @return string
     */
    protected function cleanStr($str)
    {
        return html_entity_decode(strip_tags($str), ENT_QUOTES, 'UTF-8');
    }

    /**
     * @param $uni
     *
     * @return bool|mixed|string
     */
    protected function replace_unicode_escape_sequence($uni)
    {
        return mb_convert_encoding(pack('H*', $uni[1]), 'UTF-8', 'UCS-2BE');
    }
}
