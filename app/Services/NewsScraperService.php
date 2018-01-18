<?php

namespace NewsScraper;

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
     * NewsScraperService constructor.
     * @param NewsScraperRepositoryInterface $newsScraperRepository
     */
    public function __construct(NewsScraperRepositoryInterface $newsScraperRepository)
    {
        $this->newsScraperRepository = $newsScraperRepository;
    }

    /**
     * @param int limit
     * @return array
     */
    public function listNews($limit = 100)
    {
        return [];
    }


}