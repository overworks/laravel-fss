<?php

namespace Minhyung\Fss\Tests\Feature;

use Orchestra\Testbench\Concerns\WithWorkbench;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use WithWorkbench;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
    }
}
