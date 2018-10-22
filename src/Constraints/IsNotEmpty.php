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

use Countable;
use PHPUnit\Framework\Constraint\Constraint;

class IsNotEmpty extends Constraint
{
    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return 'is not empty';
    }

    /**
     * {@inheritdoc}
     */
    protected function matches($other): bool
    {
        if ($other instanceof Countable) {
            return count($other) > 0;
        }

        return !empty($other);
    }

    /**
     * {@inheritdoc}
     */
    protected function failureDescription($other): string
    {
        $type = gettype($other);

        return sprintf(
            '%s %s %s',
            $type[0] == 'a' || $type[0] == 'o' ? 'an' : 'a',
            $type,
            $this->toString()
        );
    }
}
