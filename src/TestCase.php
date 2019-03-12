<?php
/**
 * ----------------------------------------------------------------------------
 * This code is part of an application or library developed by Datamedrix and
 * is subject to the provisions of your License Agreement with
 * Datamedrix GmbH.
 *
 * @copyright (c) 2018 Datamedrix GmbH
 * ----------------------------------------------------------------------------
 * @author Christian Graf <c.graf@datamedrix.com>
 */

declare(strict_types=1);

namespace DMX\PHPUnit\Framework;

use DMX\PHPUnit\Framework\Constraints\Carbon;
use DMX\PHPUnit\Framework\Constraints\Closure;
use DMX\PHPUnit\Framework\Constraints\IsClosure;
use DMX\PHPUnit\Framework\Constraints\IsNotEmpty;
use PHPUnit\Framework\ExpectationFailedException;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @return IsClosure
     * @codeCoverageIgnore
     */
    public static function isClosure(): IsClosure
    {
        return new IsClosure();
    }

    /**
     * @param mixed $expectedReturnValue
     *
     * @return Closure
     * @codeCoverageIgnore
     */
    public static function closure($expectedReturnValue): Closure
    {
        return new Closure($expectedReturnValue);
    }

    /**
     * @return IsNotEmpty
     * @codeCoverageIgnore
     */
    public static function isNotEmpty(): IsNotEmpty
    {
        return new IsNotEmpty();
    }

    /**
     * @param \Carbon\Carbon|string $expectedDateTime
     * @param int                   $epsilon
     *
     * @return Carbon
     * @codeCoverageIgnore
     */
    public static function carbon($expectedDateTime, int $epsilon = 0): Carbon
    {
        return new Carbon($expectedDateTime, $epsilon);
    }

    /**
     * Asserts that a value is an instance of an \Closure.
     *
     * @param mixed  $actual
     * @param string $message
     *
     * @throws ExpectationFailedException
     * @codeCoverageIgnore
     */
    public static function assertIsClosure($actual, string $message = ''): void
    {
        static::assertThat($actual, static::isClosure(), $message);
    }

    /**
     * Asserts that a value is an instance of an \Closure and the \Closure returns the expected value.
     *
     * @param mixed|null $expectedReturnValue
     * @param mixed      $actual
     * @param string     $message
     *
     * @throws ExpectationFailedException
     * @codeCoverageIgnore
     */
    public static function assertClosure($expectedReturnValue, $actual, string $message = ''): void
    {
        static::assertThat($actual, static::closure($expectedReturnValue), $message);
    }

    /**
     * @param string|\Carbon\Carbon $expectedDateTime
     * @param string|\Carbon\Carbon $actual
     * @param int                   $epsilon
     * @param string                $message
     *
     * @throws ExpectationFailedException
     * @throws \InvalidArgumentException
     * @codeCoverageIgnore
     */
    public static function assertCarbon($expectedDateTime, $actual, int $epsilon = 0, string $message = ''): void
    {
        static::assertThat($actual, static::carbon($expectedDateTime, $epsilon), $message);
    }
}
