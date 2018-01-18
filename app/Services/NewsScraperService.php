<?php

namespace App\Services;

use App\Repositories\NewsScraper\NewsScraperRepositoryInterface;
use Carbon\Carbon;
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
        foreach ($sources as $sourceType => $baseUrl) {
            switch ($sourceType) {
                case "API" :
                    $this->processAPISources($baseUrl);
                    break;

                case "RSS" :
                    //todo
                    break;

                case "DOM" :
                    //todo
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
     * @param string $url
     * @param array $parameters
     * @return mixed|null
     */
    protected function processAPISources($url, $parameters = [])
    {
        try {
            $response = $this->httpClient->get($url[0]);
            $topStoriesIds = $response->getBody()->getContents();

            array_map(array($this, 'storeStoryDetails'), json_decode($topStoriesIds));

        } catch (BadResponseException $e) {
            $body = (string)$e->getResponse()->getBody();
            $message = "Unable to parse JSON data: JSON_ERROR_SYNTAX - Syntax error, malformed JSON\n\n{$body}";
            throw (new JsonEncodingException($message));
        }
    }

    /**
     * Stores the HN Story details into the DB after calling the HN API and
     * processing the fetched data
     *
     * @param $storyId
     * @return string
     */
    private function storeStoryDetails($storyId)
    {
        $response = $this->httpClient->get("https://hacker-news.firebaseio.com/v0/item/{$storyId}.json");
        $story = $response->getBody()->getContents();
        $normalizedStory = $this->normalizeHackerNewsStory(json_decode($story, true));

        return $this->newsScraperRepository->saveStory($normalizedStory);
    }

    /**
     * Normalizes the HN story array.
     * @param $story
     * @return array
     */
    public function normalizeHackerNewsStory($story)
    {
        $story['date'] = Carbon::createFromTimestamp($story['time']);
        unset($story['time']);
        $allowed = ['date', 'title', 'summary', 'url'];

        return array_filter($story, function ($key) use ($allowed) {
            return in_array($key, $allowed);
        },
            ARRAY_FILTER_USE_KEY
        );
    }
}