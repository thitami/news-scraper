<?php

namespace App\Services;

use App\Repositories\NewsScraper\NewsScraperRepositoryInterface;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Database\Eloquent\JsonEncodingException;

/**
 * Class NewsScraperService
 * @package NewsScraper
 */
class NewsScraperService
{
    /**
     * @var NewsScraperRepositoryInterface
     */
    protected $newsScraperRepository;

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * NewsScraperService constructor.
     *
     * @param NewsScraperRepositoryInterface $newsScraperRepository
     * @param HttpClient $httpClient
     */
    public function __construct(NewsScraperRepositoryInterface $newsScraperRepository, HttpClient $httpClient)
    {
        $this->newsScraperRepository = $newsScraperRepository;
        $this->httpClient = $httpClient;

    }

    public function getSourcesNews()
    {
        $sources = config('news.sources');

        foreach ($sources as $type => $baseUrl) {

            switch ($type) {
                case "API" :
                    $topStoriesIds = $this->get('topstories.json', $baseUrl);
                    dd($topStoriesIds);
                    break;

                case "RSS" :
                    break;

                case "DOM" :
                    break;

                default:
                    break;
            }
        }
    }

    /**
     * @param int limit
     * @return array
     */
    public function listNews($limit = 100)
    {
        return [];
    }

    /**
     * GET request to API
     *
     * @param string $endpoint
     * @param string $baseUrl
     * @param array $parameters
     * @return mixed|null
     */
    protected function get($endpoint, $baseUrl, $parameters = [])
    {
        try {
            $url = $baseUrl.$endpoint;

            $response = $this->httpClient->get($url, ['query' => $parameters]);

            return $response->json();
        } catch (BadResponseException $e) {
            $body = (string)$e->getResponse()->getBody();
            $message = "Unable to parse JSON data: JSON_ERROR_SYNTAX - Syntax error, malformed JSON\n\n{$body}";

            throw (new JsonEncodingException($message))->setResponse($response);

            return null;
        }
    }
}