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

use Countable;
use PHPUnit\Framework\TestCase;
use DMX\PHPUnit\Framework\Constraints\IsNotEmpty;
use PHPUnit\Framework\ExpectationFailedException;

class IsNotEmptyTest extends TestCase
{
    /**
     * @return array
     */
    public function getNonEmptyValues()
    {
        return [
            ['foo Bar, I am loving it!'],
            [rand(1, 1000)],
            [-10],
            [12.34],
            [true],
            [new \stdClass()],
            [new class() implements Countable {
                public function count()
                {
                    return rand(1, 100);
                }
            }],
        ];
    }

    /**
     * @return array
     */
    public function getEmptyValues()
    {
        return [
            [0, 'Failed asserting that a integer is not empty.'],
            ['', 'Failed asserting that a string is not empty.'],
            [false, 'Failed asserting that a boolean is not empty.'],
            [null, 'Failed asserting that a NULL is not empty.'],
            [new class() implements Countable {
                public function count()
                {
                    return 0;
                }
            }, 'Failed asserting that an object is not empty.'],
        ];
    }

    /**
     * Test.
     */
    public function testToString()
    {
        $constraint = new IsNotEmpty();
        $this->assertEquals('is not empty', $constraint->toString());
    }

    /**
     * Test.
     *
     * @param mixed $value
     *
     * @dataProvider getNonEmptyValues
     */
    public function testEvaluateTrueForNonEmptyValues($value)
    {
        $constraint = new IsNotEmpty();

        $this->assertNull($constraint->evaluate($value));
    }

    /**
     * Test.
     *
     * @param mixed  $value
     * @param string $expectedExceptionMessage
     *
     * @dataProvider getEmptyValues
     */
    public function testEvaluateFalseForEmptyValues($value, string $expectedExceptionMessage)
    {
        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage($expectedExceptionMessage);

        $constraint = new IsNotEmpty();
        $constraint->evaluate($value);
    }
}
