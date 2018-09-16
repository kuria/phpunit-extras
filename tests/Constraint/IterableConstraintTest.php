<?php declare(strict_types=1);

namespace Kuria\PhpUnitExtras\Constraint;

use PHPUnit\Framework\ExpectationFailedException;

abstract class IterableConstraintTest extends ConstraintTest
{
    function testShouldRejectNonIterableOtherValue()
    {
        $constraint = $this->createConstraint([1, 2, 3]);

        $this->assertFalse($constraint->evaluate('not_iterable', '', true));
        $this->expectException(ExpectationFailedException::class);

        $constraint->evaluate('not_iterable');
    }
}
