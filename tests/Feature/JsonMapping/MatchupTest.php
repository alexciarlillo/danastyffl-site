<?php

namespace Tests\Feature\JsonMapping;

use JsonMapper;
use Tests\TestCase;
use App\Matchup;

class MatchupTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testJsonMappingForMatchup()
    {
        $this->withoutExceptionHandling();
        $json = json_decode(file_get_contents('http://www59.myfantasyleague.com/2015/export?TYPE=liveScoring&L=35465&W=12&JSON=1'));
        $mapper = new JsonMapper();
        $matchups = $mapper->mapArray($json->liveScoring->matchup, [], Matchup::class);

        $this->assertEquals(7, count($matchups));
    }
}
