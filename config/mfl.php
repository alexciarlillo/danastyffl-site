<?php

use Carbon\Carbon;

return [

    'api_key' => env('MFL_KEY', ''),
    'league_id' => env('MFL_LEAGUE_ID', ''),
    'league_host' => env('MFL_LEAGUE_HOST', ''),
    'league_year' => env('MFL_LEAGUE_YEAR', Carbon::now()->year)

];
