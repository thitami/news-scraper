<?php

namespace App\Repositories\NewsScraper;

use Illuminate\Support\Facades\DB;

/**
 * Class NewsScraperRepository
 * @package App\Repositories\NewsScraper
 */
class NewsScraperRepository implements NewsScraperRepositoryInterface
{
    /**
     * @param $story
     * @return bool
     */
    public function saveStory($story)
    {
        return DB::table('news')->insert($story);
    }
}