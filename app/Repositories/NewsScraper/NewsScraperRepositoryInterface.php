<?php

namespace App\Repositories\NewsScraper;


interface NewsScraperRepositoryInterface
{
    /**
     * @param $story
     * @return bool
     */
    public function saveStory($story);
}