<?php

namespace Tests\Feature\JsonMapping;

use JsonMapper;
use Tests\TestCase;

class LeagueTest extends TestCase
{
    /**
     * @group integration
     */
    public function testJsonMappingForLeague()
    {
        $this->withoutExceptionHandling();
        $json = json_decode(file_get_contents('http://www59.myfantasyleague.com/2015/export?TYPE=league&L=35465&JSON=1'));
        $mapper = new JsonMapper();
        $league = $mapper->map($json->league, new \App\League());

        $this->assertEquals('RUN TO DAYLIGHT', $league->name);
        $this->assertEquals(16, $league->rosterSize);
        $this->assertEquals(6, count($league->starters));
        $this->assertEquals(6, count($league->rosterLimits));
        $this->assertEquals(12, count($league->franchises));
    }
}
