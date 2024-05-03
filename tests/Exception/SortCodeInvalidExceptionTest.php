<?php

namespace Cs278\BankModulus\Exception;

/**
 * @covers \Cs278\BankModulus\Exception\SortCodeInvalidException
 */
final class SortCodeInvalidExceptionTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate(): void
    {
        $e = SortCodeInvalidException::create('123456', $e2 = new \Exception());

        $this->assertInstanceOf(\Cs278\BankModulus\Exception\SortCodeInvalidException::class, $e);
        $this->assertInstanceOf(\Cs278\BankModulus\Exception\InvalidArgumentException::class, $e);
        $this->assertInstanceOf(\Cs278\BankModulus\Exception\Exception::class, $e);
        $this->assertInstanceOf('InvalidArgumentException', $e);

        $this->assertSame($e2, $e->getPrevious());
        $this->assertEquals('`1****6` is not a valid sort code', $e->getMessage());
    }
}
