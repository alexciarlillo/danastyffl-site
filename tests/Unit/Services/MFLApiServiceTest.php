<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\MFLApiService;

class MFLApiServiceTest extends TestCase
{
    public function testGetLeague()
    {
        $service = app(MFLApiService::class);

        $league = $service->getLeague();

        $this->assertEquals(12, (int)$league->franchises->count);
    }
}
