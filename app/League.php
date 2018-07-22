<?php

namespace App;

use JsonMapper;

class League
{
    public $id;
    public $name;
    public $leagueLogo;
    public $baseURL;

    public $rosterSize;
    public $injuredReserve;

    public $startWeek;
    public $endWeek;
    public $lastRegularSeasonWeek;
    public $h2h;

    public $standingsSort;

    public $starters;
    public $rosterLimits;
    public $franchises;

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }


    public function setLeagueLogo(string $url)
    {
        $this->leagueLogo = $url;
    }

    public function setBaseURL(string $url)
    {
        $this->baseURL = $url;
    }

    public function setRosterSize(int $size)
    {
        $this->rosterSize = $size;
    }

    public function setInjuredReserve(int $size)
    {
        $this->injuredReserve = $size;
    }

    public function setStartWeek(int $week)
    {
        $this->startWeek = $week;
    }

    public function setEndWeek(int $week)
    {
        $this->endWeek = $week;
    }

    public function setLastRegularSeasonWeek(int $week)
    {
        $this->lastRegularSeasonWeek = $week;
    }

    public function setH2h(string $h2h)
    {
        if ($h2h === "YES") {
            $this->h2h = true;
        } else {
            $this->h2h = false;
        }
    }

    public function setStandingsSort(string $sort)
    {
        $this->standingsSort = $sort;
    }

    public function setFranchises(object $franchises)
    {
        $mapper = new JsonMapper();
        $this->franchises = $mapper->mapArray($franchises->franchise, [], Franchise::class);
    }

    public function setRosterLimits(object $rosterLimits)
    {
        $mapper = new JsonMapper();
        $this->rosterLimits = $mapper->mapArray($rosterLimits->position, [], Position::class);
    }

    public function setStarters(object $starters)
    {
        $mapper = new JsonMapper();
        $this->starters = $mapper->mapArray($starters->position, [], Position::class);
    }

    // mostly unused?
    public $taxiSquad;
    public $rostersPerPlayer;
    public $playerLimitUnit;
    public $precision;
    public $maxWaiverRounds;
    public $lockout;
    public $nflPoolStartWeek;
    public $draftPlayerPool;
    public $nflPoolType;
    public $draftLimitHours;
    public $nflPoolEndWeek;
    public $bestLineup;
    public $usesContractYear;
    public $usesSalaries;
    public $loadRosters;
}
