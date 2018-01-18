<?php

return [

    'sources' => [
        'API' => [getenv('HACKERNEWS_API_URL')],
        'RSS' => [getenv('BBC_RSS_URL')],
        'DOM' => [getenv('SLASHDOT_DOM_URL')],
    ],

];
