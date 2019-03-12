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

use SebastianBergmann\Exporter\Exporter;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\ExpectationFailedException;

class Closure extends Constraint
{
    /**
     * @var mixed|null
     */
    private $expectedReturnValue = null;

    /**
     * ClosureReturns constructor.
     *
     * @param mixed|null $expectedReturnValue
     */
    public function __construct($expectedReturnValue)
    {
        // Compatibility hack for PHPUnit ^7.0
        if (property_exists($this, 'exporter')) {
            $this->exporter = new Exporter();
        }

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
        // Compatibility hack for PHPUnit ^7.0
        if (method_exists($this, 'exporter')) {
            $exporter = $this->exporter();
        } else {
            $exporter = $this->exporter;
        }

        return sprintf(
            '%s is an instance of \Closure and returns the expected value',
            $exporter->shortenedExport($other)
        );
    }
}
