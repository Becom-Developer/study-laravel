<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class TemplateMethodTest extends TestCase
{
    // なぜか tearDown -> setUp の順で実行されるようだが原因がわからない。
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        echo __METHOD__, PHP_EOL;
    }
    protected function setUp(): void
    {
        parent::setUp();
        echo __METHOD__, PHP_EOL;
    }

    /**
     * @test
     */
    public function テストメソッド1()
    {
        echo __METHOD__, PHP_EOL;
        $this->assertTrue(true);
    }
    /**
     * @test
     */
    public function テストメソッド2()
    {
        echo __METHOD__, PHP_EOL;
        $this->assertTrue(true);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        echo __METHOD__, PHP_EOL;
    }
    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();
        echo __METHOD__, PHP_EOL;
    }
}
