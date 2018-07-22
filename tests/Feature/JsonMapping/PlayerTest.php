<?php

namespace Tests\Feature\JsonMapping;

use JsonMapper;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testJsonMappingForPlayer()
    {
        $this->withoutExceptionHandling();
        $json = json_decode(file_get_contents('https://www70.myfantasyleague.com/2018/export?TYPE=players&DETAILS=1&SINCE=&PLAYERS=13198&JSON=1'));
        $mapper = new JsonMapper();
        $player = $mapper->map($json->players->player, new \App\Player());

        $this->assertEquals('Garrett, Myles', $player->name);
        $this->assertEquals('2017', $player->draft_year);
        $this->assertEquals('1', $player->draft_round);
    }
}
