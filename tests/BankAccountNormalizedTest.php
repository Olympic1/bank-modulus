<?php

namespace Cs278\BankModulus;

/**
 * @covers \Cs278\BankModulus\BankAccountNormalized
 */
final class BankAccountNormalizedTest extends \PHPUnit\Framework\TestCase
{
    /** @dataProvider dataWithInvalidAccountNumber */
    public function testWithInvalidAccountNumber($accountNumber): void
    {
        try {
            new BankAccountNormalized(
                new BankAccount('112233', '123456'),
                '112233',
                $accountNumber
            );
        } catch (\Exception $e) {
            $this->assertInstanceOf('InvalidArgumentException', $e);
            $this->assertInstanceOf(\Cs278\BankModulus\Exception\InvalidArgumentException::class, $e);
            $this->assertInstanceOf(\Cs278\BankModulus\Exception\Exception::class, $e);

            if (\is_string($accountNumber)) {
                $this->assertInstanceOf(\Cs278\BankModulus\Exception\AccountNumberInvalidException::class, $e);
            } else {
                $this->assertNotInstanceOf(\Cs278\BankModulus\Exception\AccountNumberInvalidException::class, $e);
            }

            return;
        }

        $this->fail('Failed to catch exception');
    }

    public function testGetOriginalBankAccount(): void
    {
        $account = BankAccountNormalized::createFromBankAccount(
            $original = new BankAccount('112233', '12345678')
        );

        $this->assertSame($original, $account->getOriginalBankAccount());
    }

    public function testGetSortCodeWithObject(): void
    {
        $sortCode = new SortCode('112233');
        $account = BankAccountNormalized::createFromBankAccount(
            new BankAccount($sortCode, '12345678')
        );

        $this->assertSame($sortCode, $account->getSortCode());
    }

    public function testGetSortCodeWithString(): void
    {
        $account = BankAccountNormalized::createFromBankAccount(
            new BankAccount('11-22 33', '12345678')
        );

        $this->assertSame('112233', $account->getSortCode()->format('%s%s%s'));
    }

    public function testGetAccountNumber(): void
    {
        $account = BankAccountNormalized::createFromBankAccount(
            new BankAccount('112233', 'AC1-2345678')
        );

        $this->assertSame('12345678', $account->getAccountNumber());
    }

    public function testToString(): void
    {
        $account = BankAccountNormalized::createFromBankAccount(
            new BankAccount('144441', '25555552')
        );

        $this->assertSame('14444125555552', $account->__toString());
    }

    public static function dataWithInvalidAccountNumber(): iterable
    {
        return [
            [true],
            [12345678],
            [new \stdClass()],
            [[]],
            [''],
            ['X'],
            ['1234567A'],
            ['1234567'],
            ['123456789'],
            ['1234567890'],
        ];
    }
}
