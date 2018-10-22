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

namespace DMX\PHPUnit\Framework\Constraints;

use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\ExpectationFailedException;

class Closure extends Constraint
{
    /**
     * @var null|mixed
     */
    private $expectedReturnValue = null;

    /**
     * ClosureReturns constructor.
     *
     * @param null|mixed $expectedReturnValue
     */
    public function __construct($expectedReturnValue)
    {
        parent::__construct();

        $this->expectedReturnValue = $expectedReturnValue;
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return 'is closure';
    }

    /**
     * {@inheritdoc}
     */
    protected function matches($other): bool
    {
        if (!($other instanceof \Closure)) {
            return false;
        }

        $returnValue = $other->__invoke();
        if ($this->expectedReturnValue instanceof Constraint) {
            try {
                $this->expectedReturnValue->evaluate($returnValue);

                return true;
            } catch (ExpectationFailedException $exception) {
                return false;
            }
        } else {
            return $this->expectedReturnValue === $returnValue;
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function failureDescription($other): string
    {
        return sprintf(
            '%s is an instance of \Closure and returns the expected value',
            $this->exporter->shortenedExport($other)
        );
    }
}
