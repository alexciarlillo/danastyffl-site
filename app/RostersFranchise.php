<?php

namespace App;

use JsonMapper;

class RostersFranchise
{
    /**
     * @var string
     */
    public $id;

    public $players;

    public function setPlayer(array $players)
    {
        $mapper = new JsonMapper();
        
        $this->players = $mapper->mapArray($players, [], RostersPlayer::class);
    }
}
