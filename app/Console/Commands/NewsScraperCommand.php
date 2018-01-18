<?php

namespace App\Console\Commands;

use App\Services\NewsScraperService;
use Illuminate\Console\Command;


class NewsScraperCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:scrape';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrapes news from a list of provided sources';

    /**
     * @var NewsScraperService
     */
    protected $newsScraperService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(NewsScraperService $newsScraperService)
    {
        parent::__construct();
        $this->newsScraperService = $newsScraperService;
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Starting to scrap the data from the given sources');
        $this->newsScraperService->getSourcesNews();
        $this->info('Finished scraping the data');
    }
}
