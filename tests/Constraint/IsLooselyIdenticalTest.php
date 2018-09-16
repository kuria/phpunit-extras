<?php declare(strict_types=1);

namespace Kuria\PhpUnitExtras\Constraint;

use PHPUnit\Framework\Constraint\Constraint;

class IsLooselyIdenticalTest extends ConstraintTest
{
    function provideValues(): array
    {
        $object = new \stdClass();

        return [
            // value, otherValue, [expectedResult]
            [$object, $object],
            [$object, clone $object],
            [$object, new class extends \stdClass {}, false],
            [123, 123],
            [123, '123', false],
            [true, true],
            [true, 1, false],
        ];
    }

    protected function createConstraint($value): Constraint
    {
        return new IsLooselyIdentical($value);
    }
}
