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
use DMX\PHPUnit\Framework\Constraints\IsClosure;
use PHPUnit\Framework\ExpectationFailedException;

class IsClosureTest extends TestCase
{
    /**
     * @var IsClosure
     */
    private $constraint;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->constraint = new IsClosure();
    }

    /**
     * Test.
     */
    public function testToString()
    {
        $this->assertEquals('is closure', $this->constraint->toString());
    }

    /**
     * Test.
     */
    public function testEvaluateTrueForClosure()
    {
        $closure = function () {
            return 'foo';
        };

        $this->assertNull($this->constraint->evaluate($closure));
    }

    /**
     * Test.
     */
    public function testEvaluateFalseForNonClosures()
    {
        $closure = 'Foo.Bar';

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Failed asserting that \'Foo.Bar\' is an instance of \Closure.');

        $this->constraint->evaluate($closure);
    }
}
