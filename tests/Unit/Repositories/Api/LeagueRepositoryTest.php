<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\MFLApiService;
use App\Repositories\Api\LeagueRepository;
use App\League;

class LeagueRepositoryTest extends TestCase
{
    /**
     * This test feels a little silly...
     */
    public function testFetch()
    {
        $serviceMock = \Mockery::mock(MFLApiService::class);
        $serviceMock->shouldReceive('getLeague')->andReturn((object)[]);
        app()->instance(MFLApiService::class, $serviceMock);

        $mapperMock = \Mockery::mock(\JsonMapper::class);
        $mapperMock->shouldReceive('map')->andReturn(new League());

        $repo = app(LeagueRepository::class);
        $league = $repo->fetch();
    }
}
