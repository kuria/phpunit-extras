<?php declare(strict_types=1);

namespace Kuria\PhpUnitExtras\Constraint;

use PHPUnit\Framework\Constraint\Constraint;

class IsIdenticalIterableTest extends IterableConstraintTest
{
    function provideValues(): array
    {
        return [
            // value, otherValue, [expectedResult]
            [[1, 2, 3], new \ArrayObject([1, 2, 3])],
            [[1, 2, 3], new \ArrayObject([1, '2', 3]), false],
        ];
    }

    protected function createConstraint($value): Constraint
    {
        return new IsIdenticalIterable($value);
    }
}
