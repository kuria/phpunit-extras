<?php declare(strict_types=1);

namespace Kuria\PhpUnitExtras\Constraint;

use PHPUnit\Framework\Constraint\Constraint;

class IsEqualIterableTest extends IterableConstraintTest
{
    protected function createConstraint($value): Constraint
    {
        return new IsEqualIterable($value);
    }

    function provideValues()
    {
        return [
            // value, otherValue, [expectedResult]
            [[1, 2, 3], new \ArrayObject(['1', '2', '3'])],
            [['a', 'b', 'c'], new \ArrayObject(['a', 'x', 'c']), false],
        ];
    }
}
