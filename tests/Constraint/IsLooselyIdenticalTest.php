<?php declare(strict_types=1);

namespace Kuria\PhpUnitExtras\Constraint;

use PHPUnit\Framework\Constraint\Constraint;

class IsLooselyIdenticalTest extends ConstraintTest
{
    protected function createConstraint($value, bool $canonicalizeKeys = false): Constraint
    {
        return new IsLooselyIdentical($value, $canonicalizeKeys);
    }

    function provideValues()
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

    function testShouldEvaluateConstraintWithKeyCanonicalization()
    {
        $this->assertTrue(
            $this->createConstraint(['foo' => 123, 'bar' => 456], true)
                ->evaluate(['bar' => 456, 'foo' => 123], '', true)
        );

        $this->assertFalse(
            $this->createConstraint(['foo' => 123, 'bar' => 456], true)
                ->evaluate(['bar' => 789, 'foo' => 123], '', true)
        );
    }
}
