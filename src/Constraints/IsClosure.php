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

class IsClosure extends Constraint
{
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
        return $other instanceof \Closure;
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
            '%s is an instance of \Closure',
            $exporter->shortenedExport($other)
        );
    }
}
