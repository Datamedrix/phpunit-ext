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

namespace DMX\PHPUnit\Framework\Tests\Unit\Constraints;

use PHPUnit\Framework\TestCase;
use DMX\PHPUnit\Framework\Constraints\Carbon;
use PHPUnit\Framework\ExpectationFailedException;

class CarbonTest extends TestCase
{
    /**
     * @return array
     */
    public function getInvalidMatches(): array
    {
        return [
            [true],
            [false],
            [rand(0, 100)],
            [rand(-100, -1)],
            [123.456],
            [new \stdClass()],
            [['foo' => 'Bar']],
        ];
    }

    /**
     * @return array
     */
    public function getNotMatchingValues(): array
    {
        $now = \Carbon\Carbon::now();

        return [
            [0, 'Failed asserting that not a string or an instance of Carbon.'],
            [$now->toDateTimeString(), 'Failed asserting that DateTime \'' . $now->toDateTimeString() . '\' does not match expected \'1981-01-10 00:00:00\''],
            [false, 'Failed asserting that not a string or an instance of Carbon.'],
            [null, 'Failed asserting that not a string or an instance of Carbon.'],
            [new \stdClass(), 'Failed asserting that not a string or an instance of Carbon.'],
        ];
    }

    /**
     * Test.
     *
     * @param $invalidValue
     *
     * @dataProvider getInvalidMatches
     */
    public function testConstructorThrowsExceptionOnInvalidMatchValues(mixed $invalidValue): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $constraint = new Carbon($invalidValue, 0);
    }

    /**
     * Test.
     */
    public function testToString(): void
    {
        $constraint = new Carbon('1981-01-10', 0);
        $this->assertEquals('Carbon', $constraint->toString());
    }

    /**
     * Test.
     */
    public function testEvaluateTrueOnStringValues(): void
    {
        $constraint = new Carbon('1981-01-10');
        $this->assertNull($constraint->evaluate('1981-01-10'));

        $constraint = new Carbon('1981-01-10', 10);
        $this->assertNull($constraint->evaluate('1981-01-10'));

        $constraint = new Carbon('1981-01-10 13:31:00', 0);
        $this->assertNull($constraint->evaluate('1981-01-10 13:31:00'));

        $constraint = new Carbon('1981-01-10 13:31:00', 10);
        $this->assertNull($constraint->evaluate('1981-01-10 13:31:08'));
    }

    /**
     * Test.
     */
    public function testEvaluateTrueOnCarbonValues(): void
    {
        $constraint = new Carbon(\Carbon\Carbon::parse('1981-01-10'), 0);
        $this->assertNull($constraint->evaluate(\Carbon\Carbon::parse('1981-01-10')));

        $constraint = new Carbon(\Carbon\Carbon::parse('1981-01-10'), 10);
        $this->assertNull($constraint->evaluate(\Carbon\Carbon::parse('1981-01-10')));

        $constraint = new Carbon(\Carbon\Carbon::parse('1981-01-10 13:31:00'), 0);
        $this->assertNull($constraint->evaluate(\Carbon\Carbon::parse('1981-01-10 13:31:00')));

        $constraint = new Carbon(\Carbon\Carbon::parse('1981-01-10 13:31:00'), 10);
        $this->assertNull($constraint->evaluate(\Carbon\Carbon::parse('1981-01-10 13:31:08')));
    }

    /**
     * Test.
     *
     * @param mixed  $value
     * @param string $expectedExceptionMessage
     *
     * @dataProvider getNotMatchingValues
     */
    public function testEvaluateFalse(mixed $value, string $expectedExceptionMessage): void
    {
        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage($expectedExceptionMessage);

        $constraint = new Carbon(\Carbon\Carbon::parse('1981-01-10'));
        $constraint->evaluate($value);
    }
}
