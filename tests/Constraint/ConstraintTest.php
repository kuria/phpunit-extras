<?php declare(strict_types=1);

namespace Kuria\PhpUnitExtras\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

abstract class ConstraintTest extends TestCase
{
    /**
     * @dataProvider provideValues
     */
    function testShouldEvaluateConstraint($value, $otherValue, bool $expectedResult = true)
    {
        $constraint = $this->createConstraint($value);

        $this->assertSame($expectedResult, $constraint->evaluate($otherValue, '', true));

        if ($expectedResult) {
            $constraint->evaluate($otherValue);
        } else {
            $this->expectException(ExpectationFailedException::class);
            $constraint->evaluate($otherValue);
        }
    }

    /**
     * @dataProvider provideValues
     */
    function testShouldEvaluateConstraintWithSwappedValues($value, $otherValue, bool $expectedResult = true)
    {
        $this->assertSame($expectedResult, $this->createConstraint($otherValue)->evaluate($value, '', true));
    }

    abstract function provideValues();

    abstract protected function createConstraint($value): Constraint;
}
