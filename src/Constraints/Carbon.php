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

class Carbon extends Constraint
{
    /**
     * @var \Carbon\Carbon
     */
    private $expected;

    /**
     * @var int
     */
    private $epsilon = 0;

    /**
     * Carbon constructor.
     *
     * @param \Carbon\Carbon|string $expected
     * @param int                   $epsilon
     */
    public function __construct($expected, int $epsilon = 0)
    {
        parent::__construct();

        $this->epsilon = $epsilon;

        if ($expected instanceof \Carbon\Carbon) {
            $this->expected = $expected;
        } elseif (is_string($expected)) {
            $this->expected = \Carbon\Carbon::parse(trim($expected));
        } else {
            throw new \InvalidArgumentException('The designated match value is not an instance of Carbon or a string.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return 'Carbon';
    }

    /**
     * {@inheritdoc}
     */
    protected function matches($other): bool
    {
        if (empty($other)) {
            return false;
        }

        if (is_string($other)) {
            $other = \Carbon\Carbon::parse(trim($other));
        } elseif (!($other instanceof \Carbon\Carbon)) {
            return false;
        }

        return $this->expected->diff($other, true)->s <= $this->epsilon;
    }

    /**
     * {@inheritdoc}
     */
    protected function failureDescription($other): string
    {
        if (is_string($other)) {
            $other = \Carbon\Carbon::parse(trim($other));
        } elseif (!($other instanceof \Carbon\Carbon)) {
            return 'not a string or an instance of Carbon';
        }

        return sprintf(
            'DateTime %s does not match expected %s',
            $this->exporter->shortenedExport($other->toDateTimeString()),
            $this->exporter->shortenedExport($this->expected->toDateTimeString())
        );
    }
}
