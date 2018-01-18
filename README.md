# NEWS SCRAPER OVERVIEW
This is a basic implementation of a system built on Laravel and is designed to scrape news from various sources,
such as Hacker News, BBC and SlashDot.

# IMPLEMENTATION
Currently, it focuses on scraping data from Hacker News via its API.
The HN API does not provide an endpoint which retrieves a list of -let'say- the top news with all their details.
Therefore, the API user has to retrieve first the IDs of those news with a call to
https://hacker-news.firebaseio.com/v0/topstories.json and then iterate through the returned IDs and
perform subsequently another call to https://hacker-news.firebaseio.com/v0/item/{itemId}.json
so to get the details of each story. As a note the data need to be normalized before stored into the DB.

The main functionality is implemented through the *NewsScraperService* which is bound to the *NewsScraperRepositoryInterface*,
with the latter being responsible for the interaction with the DB (save/retrieve).
The process of data scraping is triggered by running the command `php artisan news:scrape`.

I make use of `Guzzle`, an HTTP Client responsible of the API calls. Also, before make sure that you create the DB schema
before running everything by running `php artisan migrate`

# FURTHER IMPROVEMENTS

This is an initial version of scraping the data from some news sources. That said, further improvements improve:

- Implementation of scraping via RSS feeds and DOM elements
- Introduction of Jobs and Queues so to run in an asynchronous way multiple processes
- Introduction of Clients coupled with the implementation of each source, e.g. HackerNewsClient
- Better handle of Exceptions and in specific, of the `4xx` and `5xx` status codes.
- Unit and functional tests