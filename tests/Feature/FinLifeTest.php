<?php

namespace Minhyung\Fss\Tests\Feature;

use Minhyung\Fss\FinLife\Api;
use Minhyung\Fss\FinLife\FinLife;
use Minhyung\Fss\FinLife\TopFinGrpNo;
use PHPUnit\Framework\Attributes\Depends;

class FinLifeTest extends TestCase
{
    public function testInstance(): FinLife
    {
        /** @var FinLife */
        $service = $this->app->make(FinLife::class);
        $this->assertNotNull($service);

        if ($service->isApiKeyEmpty()) {
            $this->markTestSkipped('API key did not exist.');
        }
        return $service;
    }

    #[Depends('testInstance')]
    public function testApi(FinLife $service)
    {
        $result = $service->request(Api::COMPANY, TopFinGrpNo::BANK);
        $this->assertIsArray($result);

        $result = $service->request(Api::DEPOSIT, TopFinGrpNo::BANK);
        $this->assertIsArray($result);

        $result = $service->request(Api::SAVING, TopFinGrpNo::BANK);
        $this->assertIsArray($result);

        $result = $service->request(Api::ANNUITY_SAVING, TopFinGrpNo::BANK);
        $this->assertIsArray($result);

        $result = $service->request(Api::RENT_HOUSE_LOAN, TopFinGrpNo::BANK);
        $this->assertIsArray($result);

        $result = $service->request(Api::CREDIT_LOAN, TopFinGrpNo::BANK);
        $this->assertIsArray($result);
    }
}
