<?php

namespace Minhyung\Fss\Tests\Feature;

use Minhyung\Fss\Lifespan\AreaCode;
use Minhyung\Fss\Lifespan\Lifespan;
use Minhyung\Fss\Lifespan\PsChannelCode;
use PHPUnit\Framework\Attributes\Depends;

class LifespanTest extends TestCase
{
    public function testInstance(): Lifespan
    {
        $service = $this->app->make(Lifespan::class);
        $this->assertNotNull($service);

        /** @var Lifespan */
        $service = fss_lifespan();
        $this->assertInstanceOf(Lifespan::class, $service);

        if ($service->isApiKeyEmpty()) {
            $this->markTestSkipped('API key did not exist.');
        }
        return $service;
    }

    #[Depends('testInstance')]
    public function testMethods(Lifespan $service): void
    {
        $result = $service->psCorpList(2023, 1, AreaCode::BANK);
        $this->assertIsArray($result);

        $result = $service->psProdList(2023, 1, AreaCode::BANK);
        $this->assertIsArray($result);

        $result = $service->psGuaranteedProdList(AreaCode::BANK, PsChannelCode::COMPANY);
        $this->assertIsArray($result);

        $result = $service->rpCorpResultList(2023, 1, 1);
        $this->assertIsArray($result);

        $result = $service->rpCorpBurdenRatioList(2023);
        $this->assertIsArray($result);

        $result = $service->rpCorpCustomFeeList(5);
        $this->assertIsArray($result);

        $result = $service->rpGuaranteedProdSupplyList();
        $this->assertIsArray($result);

        $result = $service->rpGuaranteedProdList(AreaCode::BANK, 3, 2023, 1);
        $this->assertIsArray($result);

        $result = $service->pensionStat();
        $this->assertIsArray($result);

        $result = $service->publicPensionStat();
        $this->assertIsArray($result);

        $result = $service->retirementPensionStat(1);
        $this->assertIsArray($result);
    }
}
