<?php

return [

    'sources' => [
        'API' => [getenv('HACKERNEWS_API_BASE_URL')],
        'RSS' => [getenv('BBC_RSS_BASE_URL')],
        'DOM' => [getenv('SLASHDOT_BASE_URL')],
    ],

];
