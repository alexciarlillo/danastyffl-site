<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\MFLApiService;

class MFLApiServiceTest extends TestCase
{

    public function setUp()
    {
        parent::setup();

        $this->api = app(MFLApiService::class);
    }

    /**
     * @group integration
     */
    public function testGetLeague()
    {
        $league = $this->api->getLeague();

        $this->assertEquals(12, (int)$league->franchises->count);
    }
}
