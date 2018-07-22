<?php

namespace App;

use JsonMapper;

class Matchup
{
    public $franchises;

    public function setFranchise(array $franchises)
    {
        $mapper = new JsonMapper();
        $this->franchises = $mapper->mapArray($franchises, [], ScoresFranchise::class);
    }
}
