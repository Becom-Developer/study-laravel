<?php

namespace Tests\Unit;

use App\Exceptions\PreconditionException;
use PHPUnit\Framework\TestCase;
use App\Services\CalculatePointService;

class CalculatePointServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }
    /**
     * @test
     */
    public function calcPoint_購入金額が0ならポイントは0()
    {
        $result = CalculatePointService::calcPoint(0);
        $this->assertSame(0, $result);
    }
    /**
     * @test
     */
    public function calcPoint_購入金額が1000ならポイントは10()
    {
        $result = CalculatePointService::calcPoint(1000);
        $this->assertSame(10, $result);
    }
    /**
     * @test
     * @dataProvider dataProvider_for_calcPoint
     */
    public function calcPoint(int $expected, int $amount)
    {
        $reuslt = CalculatePointService::calcPoint($amount);
        $this->assertSame($expected, $reuslt);
    }
    /**
     * @test
     */
    public function exception_try_catch()
    {
        try {
            throw new \InvalidArgumentException('message', 200);
            $this->fail();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\InvalidArgumentException::class, $th);
            $this->assertSame(200, $th->getCode());
            $this->assertSame('message', $th->getMessage());
            //throw $th;
        }
    }
    /**
     * @test
     */
    public function exception_expecException_method()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(200);
        $this->expectExceptionMessage('message');
        throw new \InvalidArgumentException('message', 200);
    }
    /**
     * @test
     */
    public function calcPoint_購入金額が負の数なら例外をスロー()
    {
        $this->expectException(PreconditionException::class);
        $this->expectExceptionMessage('購入金額が負の数');
        CalculatePointService::calcPoint(-1);
    }
    public function dataProvider_for_calcPoint(): array
    {
        return [
            '購入金額が0なら0ポイント' => [0, 0],
            '購入金額が999なら0ポイント' => [0, 999],
            '購入金額が1000なら10ポイント' => [10, 1000],
            '購入金額が9999なら99ポイント' => [99, 9999],
            '購入金額が10000なら200ポイント' => [200, 10000],
        ];
    }
}
