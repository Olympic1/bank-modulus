<?php

namespace Cs278\BankModulus\Internal;

use Cs278\BankModulus\Exception\InvalidArgumentException;
use Webmozart\Assert\Assert as BaseAssert;

final class Assert extends BaseAssert
{
    /**
     * @param string $message
     */
    protected static function reportInvalidArgument($message): never
    {
        throw new InvalidArgumentException($message);
    }
}
