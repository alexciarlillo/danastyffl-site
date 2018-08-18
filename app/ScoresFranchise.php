<?php

namespace App;

use JsonMapper;

class ScoresFranchise
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var int
     */
    public $playersCurrentlyPlaying;

    /**
     * @var int
     */
    public $playersYetToPlay;

    /**
     * @var int
     */
    public $gameSecondsRemaining;

    /**
     * @var bool
     */
    public $isHome;

    /**
     * @var float
     */
    public $score;

    public $players;

    public function setPlayers($players)
    {
        $mapper = new JsonMapper();
        
        if (isset($players->player)) {
            $this->players = $mapper->mapArray($players->player, [], ScoresPlayer::class);
        } else {
            $this->players = [];
        }
    }
}
