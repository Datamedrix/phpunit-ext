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
use PHPUnit\Framework\Constraint\Constraint;
use DMX\PHPUnit\Framework\Constraints\Closure;
use PHPUnit\Framework\ExpectationFailedException;

class ClosureTest extends TestCase
{
    /**
     * Test.
     */
    public function testToString()
    {
        $constraint = new Closure(null);
        $this->assertEquals('is closure', $constraint->toString());
    }

    /**
     * Test.
     */
    public function testEvaluateTrueForClosures()
    {
        $closure = function () {
            return 'foo';
        };

        $constraint = new Closure('foo');
        $this->assertNull($constraint->evaluate($closure));

        $constraint = new Closure(null);
        $this->assertNull($constraint->evaluate(function () {  }));
    }

    /**
     * Test.
     */
    public function testEvaluateTrueForClosureAndTheCorrectReturnValue()
    {
        $value = 'BAR' . rand(1000000, 999999);
        $closure = function () use ($value) {
            return $value;
        };

        $constraint = new Closure($value);
        $this->assertNull($constraint->evaluate($closure));
    }

    /**
     * Test.
     */
    public function testEvaluateTrueForClosureUsingAnConstraintValue()
    {
        $value = $this->getMockBuilder(Constraint::class)
            ->disableOriginalConstructor()
            ->getMock();

        $value
            ->expects($this->once())
            ->method('evaluate')
            ->willReturn(null)
        ;

        $closure = function () {
            return 'FooBar';
        };

        $constraint = new Closure($value);
        $this->assertNull($constraint->evaluate($closure));
    }

    /**
     * Test.
     */
    public function testEvaluateFalseForNonClosures()
    {
        $closure = 'Foo.Bar';

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Failed asserting that \'Foo.Bar\' is an instance of \Closure and returns the expected value.');

        $constraint = new Closure(null);
        $constraint->evaluate($closure);
    }

    /**
     * Test.
     */
    public function testEvaluateFalseForClosureUsingAnConstraintValue()
    {
        $value = $this->getMockBuilder(Constraint::class)
            ->disableOriginalConstructor()
            ->getMock();

        $value
            ->expects($this->once())
            ->method('evaluate')
            ->willThrowException(new ExpectationFailedException(''))
        ;

        $closure = function () {
            return 'FooBar';
        };

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Failed asserting that Closure Object (...) is an instance of \Closure and returns the expected value.');

        $constraint = new Closure($value);
        $constraint->evaluate($closure);
    }
}
